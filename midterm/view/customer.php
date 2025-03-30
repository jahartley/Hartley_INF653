<?php
/**
 * View for the main customer page, includes all vehicles, with editing feature removed.
 * 
 * @author Judson Hartley <github@jahartley.com> 20250328
 */

include('view/header.php');
?>

<div class="inline flexcenter">
    <h1>Vehicles For Sale</h1>
</div>

<!-- Section to filter by type make or class -->
<section>
    <hr>
    <form action="." method="post">
        <input type="hidden" name="page" value="vehicles">
        <div class="inline flexcenter">
        <h3>Filter Vehicles By</h3>
            <select name="filter[by]">
                <option value="all" <?php echo ($_SESSION['filter_by'] == "all") ? 'selected="selected"' : ''; ?>>All</option>
                <option value="makes" <?php echo ($_SESSION['filter_by'] == "makes") ? 'selected="selected"' : ''; ?>>Make</option>
                <option value="types" <?php echo ($_SESSION['filter_by'] == "types") ? 'selected="selected"' : ''; ?>>Type</option>
                <option value="classes" <?php echo ($_SESSION['filter_by'] == "classes") ? 'selected="selected"' : ''; ?>>Class</option>
            </select>
            <button type="submit" name="action" value="update_filter">Update</button>
        </div>
        <div>
            <?php 
            if ($_SESSION['filter_by'] == "makes" || $_SESSION['filter_by'] == "all") {
                $filterItems = $makeChoices; $filterColumn = "make"; $filterTable = "makes"; echo '<div class="inlinewrap flexcenter filterbox" >';
                foreach ($filterItems as $filterItem) : ?>
                    <div class="inline">
                        <input type="checkbox" name="filter[choices][<?= $filterTable ?>][]" value="<?= $filterItem['id'] ?>" <?php echo ($_SESSION['filter_choices'][$filterTable] != NULL && ($_SESSION['filter_by'] == $filterTable || $_SESSION['filter_by'] == "all") && in_array($filterItem['id'], $_SESSION['filter_choices'][$filterTable])) ? 'checked="checked"' : ''; ?>>
                        <span><?= $filterItem[$filterColumn] ?></span>
                    </div>
                <?php endforeach; echo '</div>';
            } 
            if ($_SESSION['filter_by'] == "types" || $_SESSION['filter_by'] == "all") {
                $filterItems = $typeChoices; $filterColumn = "type"; $filterTable = "types"; echo '<div class="inlinewrap flexcenter filterbox" >';
                foreach ($filterItems as $filterItem) : ?>
                    <div class="inline">
                        <input type="checkbox" name="filter[choices][<?= $filterTable ?>][]" value="<?= $filterItem['id'] ?>" <?php echo ($_SESSION['filter_choices'][$filterTable] != NULL && ($_SESSION['filter_by'] == $filterTable || $_SESSION['filter_by'] == "all") && in_array($filterItem['id'], $_SESSION['filter_choices'][$filterTable])) ? 'checked="checked"' : ''; ?>>
                        <span><?= $filterItem[$filterColumn] ?></span>
                    </div>
                <?php endforeach; echo '</div>';
            } 
            if ($_SESSION['filter_by'] == "classes" || $_SESSION['filter_by'] == "all") {
                $filterItems = $classChoices; $filterColumn = "class"; $filterTable = "classes"; echo '<div class="inlinewrap flexcenter filterbox" >';
                foreach ($filterItems as $filterItem) : ?>
                    <div class="inline">
                        <input type="checkbox" name="filter[choices][<?= $filterTable ?>][]" value="<?= $filterItem['id'] ?>" <?php echo ($_SESSION['filter_choices'][$filterTable] != NULL && ($_SESSION['filter_by'] == $filterTable || $_SESSION['filter_by'] == "all") && in_array($filterItem['id'], $_SESSION['filter_choices'][$filterTable])) ? 'checked="checked"' : ''; ?>>
                        <span><?= $filterItem[$filterColumn] ?></span>
                    </div>
                <?php endforeach; echo '</div>';
            } ?>
            
        </div>
    </form>
</section>

<!-- Section to Display all vehicles -->
<section>
    <hr>
    <?php if (!empty($vehicles)) : ?>
        <table style="margin-left: auto; margin-right: auto;">
            <thead>
                <?php foreach ($sortColumns as $sortName) :?>
                    <th>
                        <form action="." method="post">
                            <input type="hidden" name="page" value="vehicles">
                            <input type="hidden" name="sort_name" value="<?= $sortName ?>">
                            <button type="submit" name="action" value="update_sort"><?= ($_SESSION['sort_buttons'][$sortName]['order'] == 1) ? ucfirst($sortName) . " \u{25B2}" : (($_SESSION['sort_buttons'][$sortName]['order'] == 0) ? ucfirst($sortName) . " \u{25BC}" : ucfirst($sortName))  ?></button>
                        </form>
                    </th>
                <?php endforeach; ?>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle) : ?>
                    <tr>
                        <td><h3><?= $vehicle['year'] ?></h3></td>
                        <td><h3><?= $vehicle['make'] ?></h3></td>
                        <td><h3><?= $vehicle['model'] ?></h3></td>
                        <td><h3>$<?= $vehicle['price'] ?></h3></td>
                        <td><h3><?= $vehicle['mileage'] ?></h3></td>
                        <td><h3><?= $vehicle['type'] ?></h3></td>
                        <td><h3><?= $vehicle['class'] ?></h3></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No vehicles for sale.</p>
        <hr>
    <?php endif; ?>
</section>

<div style="height: 20px; " ></div>


<?php
include('view/footer.php');
?>