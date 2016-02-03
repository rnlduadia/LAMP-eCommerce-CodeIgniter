<tr>
    <th style="align-content: center">Username</th>
    <th style="align-content: center">Email </th>
    <th style="align-content: center; ">Company </th>
    <th style="align-content: center; ">Status </th>
</tr>

<?php foreach( $foundUsersList as $nextFoundUser ) : ?>
    <tr>
        <td><?php echo $nextFoundUser->u_id . ' : ' . $nextFoundUser->u_username; ?></td>
        <td><?php echo $nextFoundUser->u_email; ?></td>
        <td><?php echo $nextFoundUser->u_company; ?></td>
        <td><?php
            if ( empty($nextFoundUser->u_status) ) {
                echo 'Block';
            }
            if ( $nextFoundUser->u_status == 1 ) {
                echo 'Active';
            }
            if ( $nextFoundUser->u_status == 2 ) {
                echo 'Block';
            }
            ?></td>
    </tr>
<?php endforeach; ?>