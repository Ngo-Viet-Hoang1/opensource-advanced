<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chess Board</title>
</head>

<body>
    <div style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <table border="1" cellspacing='0' cellpadding='10'>
            @for ($i = 0; $i < $n; $i++)
                <tr>
                    @for ($j = 0; $j < $n; $j++)
                        @if (($i + $j) % 2 === 0)
                            <td @style('background-color: black')></td>
                        @else
                            <td style="background-color: white"></td>
                        @endif
                    @endfor
                </tr>

            @endfor
        </table>

    </div>
</body>

</html>
