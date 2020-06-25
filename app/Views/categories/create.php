<?php

echo '<h1> Create New Category </h1>';

if(isset($_SESSION['error'])):
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>'. $_SESSION['error'] .'</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
endif;

$validation = \Config\Services::validation();

?>
<form action="/category/store" method="post">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" value="<?= old('title')?>"id="title" class="form-control">
        <?= $validation->getError('title') ? '<p class="alert alert-danger lead">'. $validation->getError('title'). ' </p>' : '';?>
    </div>
    <div class="form-group">
        <label for="1">Parent Category</label>
        <select name='parent_id' class='custom-select' id='1' onchange='getSubCategory(this)'>
            <option disabled value='0'>Please Select Your Category</option>
            <?php
                print($categories);
            ?>
        </select>
    </div>
    
    <input type="submit" class="btn btn-success" value="Submit">

</form>