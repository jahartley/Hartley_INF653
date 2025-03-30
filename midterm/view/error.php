<?php
/**
 * Generic Error Page.
 * 
 * @author Judson Hartley <github@jahartley.com> 20250328
 */

include('view/header.php');
?>

<!-- Section to display errors -->
<section class="error">
    <h2>ERROR</h2>
    <?php if (!empty($error)) : ?>
        <p><strong><?= htmlspecialchars($error) ?></strong></p>
    <?php else : ?>
        <p>Unspecified Error, try again.</p>
    <?php endif; ?>
    <hr>
    <?php var_dump(get_defined_vars()); ?>
</section>

<p><a href=".">Home</a></p>

<?php
include('view/footer.php');
?>