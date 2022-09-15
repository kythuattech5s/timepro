<ul class="rating-list">
    @foreach ([
        [
            'name' => 'percentFiveStar',
            'percent' => '100%',
            'number' => 5,
            'count' => 'fiveStar',
        ],
        [
            'name' => 'percentFourStar',
            'percent' => '80%',
            'number' => 4,
            'count' => 'fourStar',
        ],
        [
            'name' => 'percentThreeStar',
            'percent' => '60%',
            'number' => 3,
            'count' => 'threeStar',
        ],
        [
            'name' => 'percentTwoStar',
            'percent' => '40%',
            'number' => 2,
            'count' => 'twoStar',
        ],
        [
            'name' => 'percentOneStar',
            'percent' => '20%',
            'number' => 1,
            'count' => 'oneStar',
        ],
    ] as $type)
        <li class="space-x-2">
            <p>
                <span class="ml-2 font-semibold">{{ $type['number'] }}</span>
                <i class="fa-solid fa-star text-[#F99F1B]"></i>
            </p>
            <div class="rating-list__item">
                <div class="progress-bar" role="progressbar"
                     style="--percent:{{ $ratings[$type['name']] . '%' }} !important"
                     aria-valuenow="25"
                     aria-valuemin="0" aria-valuemax="{{ $ratings[$type['name']] }}"></div>
            </div>
            <p class="rating-list__star-percent font-semibold">{{ $ratings[$type['name']] }}%</p>
            <p class="text-[#888888] border-l pl-3">{{ $ratings[$type['count']] }} đánh giá</p>
        </li>
    @endforeach
</ul>
