<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="<?php echo e(url('/')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo Support::asset('assets/css/font-awesome.min.css')?>" type="text/css" media="screen" />
    <link href="<?php echo Support::asset('comment/css/style.css')?>" rel="stylesheet">
    <link href="<?php echo Support::asset('comment/css/star.css')?>" rel="stylesheet">
    <link href="<?php echo Support::asset('comment/css/selectStar.css')?>" rel="stylesheet">
    <link href="<?php echo e(mix('comment/style/app.css')); ?>" rel="stylesheet">
</head>

<body>
    <?php
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
        
    ?>
    <div class="comment-box">
        <?php echo $__env->make('commentRS::comment_box', [
            'map_table' => 'products',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <script src="<?php echo Support::asset('assets/js/FormData.js')?>" defer></script>
    <script src="<?php echo Support::asset('assets/js/ValidateFormHasFile.js')?>" defer></script>
    <script src="<?php echo Support::asset('assets/js/XHR.js')?>" defer></script>
    <script src="<?php echo Support::asset('comment/js/comment.js')?>" defer></script>
</body>

</html>
<?php /**PATH H:\laragon\www\timepro\packages\roniejisa\comment\src\Providers/../../views/view.blade.php ENDPATH**/ ?>