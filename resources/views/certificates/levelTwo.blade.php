<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .main-certificate {
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            text-align: center;
            background: #f5f2f2;
        }

        .side-corner {
            margin-top: 20px;
            max-width: 342px;
            position: absolute;
            left: 4%;
        }

        .top-corner, .bottom-corner {
            position: absolute;
            right: 35.5%;
            max-width: 355px;
        }

        .bottom-corner {
            left: 0;
            top: 56%;
        }

        h1, h2 {
            font-family: sans-serif;
            font-size: 70px;
            color: #a3680f;
            padding-top: 10%;
            margin-bottom: 0;
            font-weight: 100;
            font-style: italic;
        }

        h2 {
            font-size: 48px;
            padding-top: 0;
            margin: 0;
        }

        p {
            text-transform: none;
            font-family: 'Open Sans', sans-serif;
        }

        .border-bottom {
            border-bottom: 2px solid #000;
            width: 70%;
            margin: 0 auto;
        }

        .para {
            padding: 20px 0;
        }

        .para p {
            text-transform: none;
            text-align: center;
            padding-bottom: 1rem;
            font-family: 'Open Sans', sans-serif;
            color: #a3680f;
            font-size: 16px;
            margin: 0;
            padding: 0;
        }

        .tb-content {
            max-width: 466px;
            margin: 0 auto;
            text-align: center;
        }

        .tb-content p {
            font-family: 'Open Sans';
            font-style: italic;
            font-size: 12px;
            text-transform: none;
        }
    </style>
</head>
<body>
<div class="main-certificate">
    <img class="top-corner" src="{{asset('assets/certificates/green.png')}}" alt="">
    <img class="side-corner" src="{{asset('assets/certificates/green-line.png')}}">
    <h1> Award Certificate</h1>
    <p> The Certificate is humbly presented to</p>
    <h2> {{ $certificate->student->profile->full_name }}</h2>
    <div class="border-bottom"></div>
    <div class="para">
        <p>FOR</p>
        <p>COMPLETING LEVEL TWO</p>
        <p>OF LAMP AND LIGHT CORRESPONDENCE COURSES</p>
    </div>
    <div class="tb-content">
        <p><img src="{{asset('assets/certificates/icon.png')}}" alt="certificate-icon"
                style="width:100px;height:100px; float: right;margin-top:-14%;margin-right:-25%;">
            Congratulations! we trust you have advanced in our knowledge of the basic Bible doctrines and New Testament
            ordinances. We also hope you have taken steps forward in obedience to what you have learned.
        </p>
        <p>We urge you to continue to press forward under Christ's leadership, march at His command, and joyfully endure
            the rigors incurred in the conflict. Follow the example of your divine Prince. Keep in step with Hin.
            Victory is yours!</p>
    </div>
    <div class="tb-name">
        <table>
            <tbody>
            <tr>
                <td style="padding-top: 25px; padding-left:500px;">
                    <table style=" margin: 0 auto;">
                        <tbody>
                        <tr>
                            <td style=" font-family: 'Open Sans', sans-serif;
                               font-size: 14px;
                               text-transform: capitalize;">
                                {{ $certificate->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom:2px solid #000"></td>
                        </tr>
                        <tr align="center">
                            <td style="    font-family: 'Open Sans', sans-serif;
                               font-size: 14px;
                               text-transform: capitalize;">date
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td style="padding-top: 25px;padding-left: 100px;">
                    <table style="text-align: center;">
                        <tbody>
                        <tr>
                            <td style="    font-family: 'Open Sans', sans-serif;
                               font-size: 14px;
                               text-transform: capitalize;">
                                {{ date_format($certificate->created_at,'F dS Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom:2px solid #000"></td>
                        </tr>
                        <tr>
                            <td style="    font-family: 'Open Sans', sans-serif;
                               font-size: 14px;
                               text-transform: capitalize;">Teacher
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div>
        <table>
            <tbody>
            <tr>
                <td style="padding-top: 25px; padding-left:400px;">
                    <table style=" margin: 0 auto;">
                        <tbody>
                        <tr>
                            <td style="    font-family: 'Open Sans', sans-serif;
                               font-size: 8px; width: 100px;
                               text-transform: capitalize;">
                                Lamp and light of Kenya
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td style="padding-top: 25px;padding-left: 10px;">
                    <table style="text-align: center;">
                        <tbody>
                        <tr>
                            <td style="    font-family: 'Open Sans', sans-serif;
                               font-size: 8px;
                               text-transform: capitalize;">
                                P.O. Box 9602 Lanet, Kenya, 20112
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <img class="bottom-corner" src="{{asset('assets/certificates/green-2.png')}}" alt="">
</div>
</body>
</html>
