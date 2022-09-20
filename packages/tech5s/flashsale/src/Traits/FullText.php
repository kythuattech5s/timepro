<?php

namespace Tech5s\FlashSale\Traits;

trait FullText
{
    protected function fullTextWildcardLike($term, $isArray = false)
    {
        $reservedSymbols = ['+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);
        $words = explode(' ', $term);
        if ($isArray) {
            return $words;
        }
        foreach ($words as $key => $word) {
            if (strlen($word) >= 1) {
                $words[$key] = '+' . $word . '*';
            }
        }
        return implode(' ', $words);
    }

    public function FullTextSearch($query, $columns, $term)
    {
        $minWordLength = $this->getLengthWordCurrent();
        $NO_FULLTEXT = false;
        if (mb_strlen($term) < $minWordLength || $NO_FULLTEXT) {
            $words = $this->fullTextWildcardLike($term, true);
            $query->where(function ($q) use ($words, $columns) {
                foreach ($words as $key => $word) {
                    $word = strtolower($word);
                    if ($key == 0) {
                        $q->whereRaw("LOWER($columns) LIKE BINARY '%$word%'");
                    } else {
                        $q->orWhereRaw("LOWER($columns) LIKE BINARY '%$word%'");
                    }
                }
            })->orderByRaw("CASE
            WHEN " . $columns . " LIKE '" . $term . "%' THEN 1
            WHEN " . $columns . " LIKE '%" . $term . "' THEN 3
            ELSE 2
        END");
        } elseif (count(explode(' ', $term)) > 4) {
            $query->selectRaw(\DB::raw('*,MATCH(' . $columns . ') AGAINST ("' . $term . '") as relevance'))
                ->whereRaw('MATCH(' . $columns . ') AGAINST (?)', [$term])
                ->orderBy('relevance', 'DESC');
        } elseif (count(explode(' ', $term)) >= 2) {
            $words = $this->fullTextWildcardLike($term, true);
            $query->selectRaw(\DB::raw('*'))->where(function ($q) use ($columns, $words) {
                foreach ($words as $key => $word) {
                    $q->orWhereRaw('MATCH(' . $columns . ') AGAINST (? IN BOOLEAN MODE)', [$word]);
                }
            });
        } else {
            $words = $this->fullTextWildcardLike($term);
            $query->selectRaw(\DB::raw('*,MATCH(' . $columns . ') AGAINST ("' . $words . ' IN BOOLEAN MODE") as relevance'))
                ->whereRaw('MATCH(' . $columns . ') AGAINST (? IN BOOLEAN MODE)', [$words])
                ->orderBy('relevance', 'DESC');
        }
        return $query;
    }

    public function getLengthWordCurrent()
    {
        if (!\Cache::has('min_word_length')) {
            \Cache::rememberForever('min_word_length', function () {
                return (int) \DB::select('show variables like "ft_min_word_len"')[0]->Value;
            });
        }
        return \Cache::get('min_word_length');
    }
}
