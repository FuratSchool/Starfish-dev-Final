<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="10;url={{route('admin.specialisms.show', $spec->id)}}">
    <title>Gegevens worden verwerkt</title>
</head>
<style>
    body {
        margin-top: 100px;
        background-color: #0e75e5;
        overflow: hidden;
    }

    h1 {
        width: 100%;
        font-size: 4em;
        text-align: center;
        color: white;
        font-family: 'Raleway', sans-serif;
    }
    .cssload-container {
        width: 600px;
        margin: 0 auto;
    }

    .cssload-circle-1 {
        height: 600px;
        width: 600px;
        background: #ff0000;
    }

    .cssload-circle-2 {
        height: 500px;
        width: 500px;
        background: #ff7f00;
    }

    .cssload-circle-3 {
        height: 400px;
        width: 400px;
        background: #ffff00;
    }

    .cssload-circle-4 {
        height: 300px;
        width: 300px;
        background: #00ff00;
    }

    .cssload-circle-5 {
        height: 200px;
        width: 200px;
        background: #00ffff;
    }

    .cssload-circle-6 {
        height: 100px;
        width: 100px;
        background: #0000ff;
    }

    .cssload-circle-7 {
        height: 50px;
        width: 50px;
        background: #7f00ff;
    }

    .cssload-circle-8 {
        height: 25px;
        width: 25px;
        background: #ff00ff;
    }

    .cssload-circle-1,
    .cssload-circle-2,
    .cssload-circle-3,
    .cssload-circle-4,
    .cssload-circle-5,
    .cssload-circle-6,
    .cssload-circle-7,
    .cssload-circle-8 {
        border-bottom: none;
        border-radius: 50%;
        -o-border-radius: 50%;
        -ms-border-radius: 50%;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        box-shadow: 5px 5px 5px rgba(0,0,0,0.1);
        -o-box-shadow: 5px 5px 5px rgba(0,0,0,0.1);
        -ms-box-shadow: 5px 5px 5px rgba(0,0,0,0.1);
        -webkit-box-shadow: 5px 5px 5px rgba(0,0,0,0.1);
        -moz-box-shadow: 5px 5px 5px rgba(0,0,0,0.1);
        animation-name: cssload-spin;
        -o-animation-name: cssload-spin;
        -ms-animation-name: cssload-spin;
        -webkit-animation-name: cssload-spin;
        -moz-animation-name: cssload-spin;
        animation-duration: 2800ms;
        -o-animation-duration: 2800ms;
        -ms-animation-duration: 2800ms;
        -webkit-animation-duration: 2800ms;
        -moz-animation-duration: 2800ms;
        animation-iteration-count: infinite;
        -o-animation-iteration-count: infinite;
        -ms-animation-iteration-count: infinite;
        -webkit-animation-iteration-count: infinite;
        -moz-animation-iteration-count: infinite;
        animation-timing-function: linear;
        -o-animation-timing-function: linear;
        -ms-animation-timing-function: linear;
        -webkit-animation-timing-function: linear;
        -moz-animation-timing-function: linear;
    }



    @keyframes cssload-spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    @-o-keyframes cssload-spin {
        from {
            -o-transform: rotate(0deg);
        }
        to {
            -o-transform: rotate(360deg);
        }
    }

    @-ms-keyframes cssload-spin {
        from {
            -ms-transform: rotate(0deg);
        }
        to {
            -ms-transform: rotate(360deg);
        }
    }

    @-webkit-keyframes cssload-spin {
        from {
            -webkit-transform: rotate(0deg);
        }
        to {
            -webkit-transform: rotate(360deg);
        }
    }

    @-moz-keyframes cssload-spin {
        from {
            -moz-transform: rotate(0deg);
        }
        to {
            -moz-transform: rotate(360deg);
        }
    }
</style>
<body>
<div class="cssload-container">
    <div class="cssload-circle-1">
        <div class="cssload-circle-2">
            <div class="cssload-circle-3">
                <div class="cssload-circle-4">
                    <div class="cssload-circle-5">
                        <div class="cssload-circle-6">
                            <div class="cssload-circle-7">
                                <div class="cssload-circle-8">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h1>Het duurt allemaal wat langer dan gehoopt...</h1>
</body>
</html>