        <style>
            table{
                width:500px;
                height:auto;
                margin:auto;
                font-family:helvetica;
                font-size:14px;
                border:1px solid #222;
                border-collapse:collapse;
            }
            table tr{
                height:30px;
                
            }
            table td{
                border:1px solid #222;
                border-collapse:collapse;
                padding:6px;
            }
            tr.odd{
                background-color:#EEE;
            }
        </style>

        <table>
            <tr>
                <td>Name</td>
                <td><?php echo $name; ?></td>
            </tr>
            <tr class='odd'>
                <td>Email</td>
                <td><?php echo $email; ?></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><?php echo $phone; ?></td>
            </tr>
            <tr class='odd'>
                <td>Message</td>
                <td><?php echo $message; ?></td>
            </tr>
        </table>