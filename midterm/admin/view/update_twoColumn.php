<?php
/**
 * View for two column table CRUD.
 * 
 * @author Judson Hartley <github@jahartley.com> 20250328
 * 
 * @param string $table sets the table to use for this controller to function.
 * @param string $column sets the column name.
 * @param array $all the collection of table entries to display.
 * @var array $all contains an "id" and "column" for each item
 * 
 */

include('../view/header.php');
?>

<!-- Section to Display twoColumn table info -->
<section class="twoColumn-container">
    <h2>Update <?= ucfirst($table) ?></h2>
    <?php if (!empty($all)) : ?>
        <?php foreach ($all as $item) : ?>
            <div style="display: flex; flex-direction: row; column-gap: 4px; margin-bottom: 6px; ">
            <form action="." method="post">
                <input type="hidden" name="page" value="editTwo">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <input type="hidden" name="table" value="<?= $table ?>">
                <input type="text" name="value" maxlength="50" placeholder="Description" required value="<?= $item[$column] ?>">
                <button type="submit" name="action" value="update_one">Update</button>
            </form>
            <form action="." method="post" >
                <input type="hidden" name="page" value="editTwo">
                <input type="hidden" name="action" value="delete_one">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <input type="hidden" name="table" value="<?= $table ?>">
                <button class="remove-button" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
            </form>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Currently, there are no items.</p>
    <?php endif; ?>
</section>

<!-- Add Item Form -->
<section>
    <h2>Add <?= ucfirst($column) ?></h2>
    <form action="." method="post">
        <input type="hidden" name="page" value="editTwo">
        <input type="hidden" name="table" value="<?= $table ?>">
        <input type="text" name="value" maxlength="50" placeholder="Description" autofocus required >
        <button type="submit" name="action" value="add_one">Add <?= $column ?></button>
    </form>
</section>

<p><a href=".">Back to Admin</a></p>

<?php
include('../view/footer.php');
?>
