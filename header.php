<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="author" content="TSS">
<link rel="preconnect" href="https://fonts.gstatic.com/">
<link rel="shortcut icon" href="img/logo.png" />

<link rel="canonical" href="index.php" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>-->
<!-- Choose your prefered color scheme -->
<link href="css/light.css" rel="stylesheet">
<!-- <link href="css/dark.css" rel="stylesheet"> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"   />
<style>

    .rating {
        border: none;
        margin-right: 49px
    }

    .myratings {
        font-size: 42px;
        color: green
    }

    .rating>[id^="star"] {
        display: none
    }

    .rating>label:before {
        margin: 5px;
        font-size: 2.25em;
        font-family: FontAwesome;
        display: inline-block;
        content: "\f005"
    }

    .rating>.half:before {
        content: "\f089";
        position: absolute
    }

    .rating>label {
        color: #ddd;
        float: right
    }

    .rating>[id^="star"]:checked~label,
    .rating:not(:checked)>label:hover,
    .rating:not(:checked)>label:hover~label {
        color: #FFD700
    }

    .rating>[id^="star"]:checked+label:hover,
    .rating>[id^="star"]:checked~label:hover,
    .rating>label:hover~[id^="star"]:checked~label,
    .rating>[id^="star"]:checked~label:hover~label {
        color: #FFED85
    }

    .reset-option {
        display: none
    }

    .reset-button {
        margin: 6px 12px;
        background-color: rgb(255, 255, 255);
        text-transform: uppercase
    }
    .rating>[id^="rstar"] {
        display: none
    }
    .rating>[id^="rstar"]:checked~label,
    .rating:not(:checked)>label:hover,
    .rating:not(:checked)>label:hover~label {
        color: #FFD700
    }

    .rating>[id^="rstar"]:checked+label:hover,
    .rating>[id^="rstar"]:checked~label:hover,
    .rating>label:hover~[id^="rstar"]:checked~label,
    .rating>[id^="rstar"]:checked~label:hover~label {
        color: #FFED85
    }

    .checked {
        color: orange;
    }
</style>