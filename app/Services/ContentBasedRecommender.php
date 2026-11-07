<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ContentBasedRecommender
{
    public function recommend(int $customerId, int $limit = 6): array
    {
        // 1. Ambil seluruh paket
        $packages = DB::table('packages')->get();

        if ($packages->isEmpty()) {
            return [];
        }

        // 2. Ambil riwayat booking pelanggan
        $history = DB::table('bookings')
            ->where('customer_id', $customerId)
            ->pluck('package_id')
            ->unique()
            ->values()
            ->all();

        if (empty($history)) {
            return [];
        }

        // 3. Bentuk dokumen teks dari setiap paket
        $documents = [];

        foreach ($packages as $package) {
            $text = $package->kategori_layanan . ' '
                  . $package->nama_paket . ' '
                  . $package->deskripsi;

            $documents[$package->id] = $this->tokenize($text);
        }

        // 4. Hitung Document Frequency (DF)
        $documentFrequency = [];

        foreach ($documents as $tokens) {
            foreach (array_unique($tokens) as $token) {
                $documentFrequency[$token] =
                    ($documentFrequency[$token] ?? 0) + 1;
            }
        }

        // 5. Hitung Inverse Document Frequency (IDF)
        $totalDocuments = count($documents);
        $idf = [];

        foreach ($documentFrequency as $term => $frequency) {
            $idf[$term] = log(
                ($totalDocuments + 1) / ($frequency + 1)
            ) + 1;
        }

        // 6. Bentuk vektor TF-IDF setiap paket
        $vectors = [];

        foreach ($documents as $packageId => $tokens) {
            $termFrequency = array_count_values($tokens);
            $totalTerms = count($tokens);
            $vector = [];

            if ($totalTerms > 0) {
                foreach ($termFrequency as $term => $count) {
                    $tf = $count / $totalTerms;
                    $vector[$term] = $tf * ($idf[$term] ?? 0);
                }
            }

            $vectors[$packageId] = $vector;
        }

        // 7. Bentuk profil minat pelanggan dari riwayat booking
        $userProfile = [];

        foreach ($history as $packageId) {
            if (!isset($vectors[$packageId])) {
                continue;
            }

            foreach ($vectors[$packageId] as $term => $weight) {
                $userProfile[$term] =
                    ($userProfile[$term] ?? 0) + $weight;
            }
        }

        // 8. Hitung Cosine Similarity dan urutkan rekomendasi
        $recommendations = [];

        foreach ($packages as $package) {
            // Jangan rekomendasikan paket yang sudah pernah dibooking
            if (in_array($package->id, $history)) {
                continue;
            }

            $score = $this->cosineSimilarity(
                $userProfile,
                $vectors[$package->id] ?? []
            );

            if ($score > 0) {
                $package->similarity_score = round($score * 100, 2);
                $recommendations[] = $package;
            }
        }

        usort($recommendations, function ($a, $b) {
            return $b->similarity_score <=> $a->similarity_score;
        });

        return array_slice($recommendations, 0, $limit);
    }

    // Mengubah teks menjadi token/kata
    private function tokenize(string $text): array
    {
        $text = mb_strtolower($text, 'UTF-8');

        $tokens = preg_split(
            '/[^\p{L}\p{N}]+/u',
            $text,
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        $stopWords = [
            'dan', 'atau', 'yang', 'di', 'ke', 'dari',
            'untuk', 'dengan', 'pada', 'ini', 'itu',
            'dalam', 'serta', 'adalah', 'akan', 'lebih',
            'paket', 'orang'
        ];

        return array_values(array_filter($tokens, function ($token) use ($stopWords) {
            return !in_array($token, $stopWords)
                && mb_strlen($token) > 1;
        }));
    }

    // Menghitung Cosine Similarity
    private function cosineSimilarity(array $vectorA, array $vectorB): float
    {
        if (empty($vectorA) || empty($vectorB)) {
            return 0;
        }

        $dotProduct = 0;

        foreach ($vectorA as $term => $weight) {
            if (isset($vectorB[$term])) {
                $dotProduct += $weight * $vectorB[$term];
            }
        }

        $magnitudeA = sqrt(
            array_sum(array_map(
                fn($value) => $value ** 2,
                $vectorA
            ))
        );

        $magnitudeB = sqrt(
            array_sum(array_map(
                fn($value) => $value ** 2,
                $vectorB
            ))
        );

        if ($magnitudeA == 0 || $magnitudeB == 0) {
            return 0;
        }

        return $dotProduct / ($magnitudeA * $magnitudeB);
    }
}
