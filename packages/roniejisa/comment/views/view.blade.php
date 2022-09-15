<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="{{ url('/') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{'assets/css/font-awesome.min.css'}" type="text/css" media="screen" />
    <link href="{'comment/css/style.css'}" rel="stylesheet">
    <link href="{'comment/css/star.css'}" rel="stylesheet">
    <link href="{'comment/css/selectStar.css'}" rel="stylesheet">
    <link href="{{ mix('comment/style/app.css') }}" rel="stylesheet">
</head>

<body>
    @php
        // $currentItem = App\Models\Product::find(1);
        // $ratings = $currentItem->getRating();
        $currentItem = new stdClass();
        $currentItem->id = 1;
        $comments = Roniejisa\Comment\Models\Comment::where('act', 1)->whereNull('comment_id')->orderBy('id','DESC')->paginate(5);
        $ratings = [
            'scoreAll' => 5,
            'percentAll' => 10,
            'totalRating' => 1,
            'percentFiveStar' => 2,
            'percentFourStar' => 2,
            'percentThreeStar' => 2,
            'percentTwoStar' => 2,
            'percentOneStar' => 2,
            'percentFiveStar' => 2,
            'oneStar' => 2,
            'twoStar' => 3,
            'threeStar' => 4,
            'fourStar' => 5,
            'fiveStar' => 6,
        ];
        
    @endphp
    <div class="comment-box">
        @include('commentRS::comment_box', [
            'map_table' => 'products',
        ])
    </div>

    <script src="{'assets/js/FormData.js'}" defer></script>
    <script src="{'assets/js/ValidateFormHasFile.js'}" defer></script>
    <script src="{'assets/js/XHR.js'}" defer></script>
    <script src="{'comment/js/comment.js'}" defer></script>
</body>

</html>
