<?php

debug($user);
echo anchor(base_url('user/edit/'.$user->id), 'Edit', 'title="Edit"');
?>
