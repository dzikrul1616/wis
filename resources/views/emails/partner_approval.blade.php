<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title }}</title>
    <style>
        /* Base ------------------------------ */
        *:not(br):not(tr):not(html) {
            font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            width: 100% !important;
            height: 100%;
            margin: 0;
            line-height: 1.4;
            background-color: #F5F7F9;
            /*color: black;*/
            -webkit-text-size-adjust: none;
        }

        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            /*margin-bottom: 1rem!important;*/
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-header:first-child {
            border-radius: calc(.25rem - 0) calc(.25rem - 0) 0 0;
            position: relative;
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            padding: .75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, .03);
            border-bottom: 0 solid rgba(0, 0, 0, .125);
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 400;
            margin: 0;
        }

        .bg-info {
            background-color: #17a2b8 !important;
            color: #fff !important;
        }
    </style>
</head>

<body>

    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <div class="card" style="width:90%">
                    <div class="card-body" style="border: 1px solid #000">
                        <h4>Dear {{ $to_name }}</h4>
                        <div>
                            <hr width="60%">
                            <p>
                                {!! $content !!}
                            </p>

                            <br><br><br>
                            <hr width="60%">
                            <p>Thank you,<br>Wise App Team</p>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
