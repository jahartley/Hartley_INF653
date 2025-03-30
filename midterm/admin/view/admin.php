<?php
/**
 * View for the main Admin page, includes all vehicles, vehicle CRUD operations, and links to other admin pages.
 * 
 * @author Judson Hartley <github@jahartley.com> 20250328
 */

include('../view/header.php');
?>

<div class="inline flexcenter">
    <h1>Admin Page</h1>
</div>

<!-- Section for filter by type make or class -->
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

<!-- Section for sort by controls -->
<section>
    <hr>
    <div class="inlinewrap flexcenter">
        <h3>Sort Vehicles By</h3>
        <?php foreach ($sortColumns as $sortName) :?>
            <form action="." method="post">
                <input type="hidden" name="page" value="vehicles">
                <input type="hidden" name="sort_name" value="<?= $sortName ?>">
                <button type="submit" name="action" value="update_sort"><?= ($_SESSION['sort_buttons'][$sortName]['order'] == 1) ? ucfirst($sortName) . " \u{25B2}" : (($_SESSION['sort_buttons'][$sortName]['order'] == 0) ? ucfirst($sortName) . " \u{25BC}" : ucfirst($sortName))  ?></button>
            </form>
        <?php endforeach; ?>
    </div>
    <hr>
</section>

<!-- Section to Display all vehicles -->
<section>
    <?php if (!empty($vehicles)) : ?>
        <table><tbody>
        <?php foreach ($vehicles as $vehicle) : ?>
            <tr><td>
            <form action="." method="post">
                <input type="hidden" name="page" value="vehicles">
                <input type="hidden" name="vehicle[id]" value="<?= $vehicle['id'] ?>">
                <div class="inlinewrap">
                    <div class="inline">
                        <span>Year</span> 
                        <input type="number" name="vehicle[year]" value="<?= $vehicle['year'] ?>" min="1880" max="3000" step="1">
                    </div>
                    <div class="inline">
                        <span>Make</span>
                        <select name="vehicle[make_id]">
                            <?php foreach ($makeChoices as $mc) : ?>
                                <option value="<?= $mc['id'] ?>" <?php echo ($mc['id'] == $vehicle['make_id']) ? 'selected="selected"' : ''; ?>><?= $mc['make'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="inline">
                        <span>Model</span>
                        <input type="text" name="vehicle[model]" maxlength="50" placeholder="model" required value="<?= $vehicle['model'] ?>">
                    </div>
                    <div class="inline">
                        <span>Price $</span>
                        <input type="number" name="vehicle[price]" value="<?= $vehicle['price'] ?>" min="0" max="1000000000" step="1">
                    </div>
                    <div class="inline">
                        <span>Mileage</span>
                        <input type="number" name="vehicle[mileage]" value="<?= $vehicle['mileage'] ?>" min="0" max="1000000000" step="1">
                    </div>
                    <div class="inline">
                        <span>Type</span>
                        <select name="vehicle[type_id]">
                            <?php foreach ($typeChoices as $tc) : ?>
                                <option value="<?= $tc['id'] ?>" <?php echo ($tc['id'] == $vehicle['type_id']) ? 'selected="selected"' : ''; ?>><?= $tc['type'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="inline">
                        <span>Class</span>
                        <select name="vehicle[class_id]">
                            <?php foreach ($classChoices as $cc) : ?>
                                <option value="<?= $cc['id'] ?>" <?php echo ($cc['id'] == $vehicle['class_id']) ? 'selected="selected"' : ''; ?>><?= $cc['class'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="inline">
                        <span>Cost $</span>
                        <input type="number" name="vehicle[cost]" value="<?= $vehicle['cost'] ?>" min="0" max="1000000000" step="1">
                    </div>
                    <div class="inline">
                        <span>Profit $</span>
                        <input type="number" name="vehicle[profit]" value="<?= $vehicle['price'] - $vehicle['cost'] ?>" min="-1000000000" max="1000000000" step="1" readonly>
                    </div>
                    <button type="submit" name="action" value="update_vehicle">Update</button>
                    <button type="submit" name="action" value="delete_vehicle" onclick="return confirm('Are you sure you want to delete this vehicle?')">Delete</button>
                </div>
            </form>
            </td></tr>
        <?php endforeach; ?>
        </tbody></table>
    <?php else : ?>
        <p>No vehicles for sale.</p>
        <hr>
    <?php endif; ?>
</section>

<div style="height: 20px; " ></div>

<!-- Section of links to edit types, makes, classes -->
<section>
    <hr>
    <div class="inline flexcenter" >
        <h3>Add a vehicle for sale</h3>
    </div>
    <Form action="." method="post">
        <div class="inlinewrap">
            <div class="inline">
                <span>Year</span> 
                <input type="number" name="vehicle[year]" value="2020" min="1880" max="3000" step="1">
            </div>
            <div class="inline">
                <span>Make</span>
                <select name="vehicle[make_id]">
                    <?php foreach ($makeChoices as $mc) : ?>
                        <option value="<?= $mc['id'] ?>" ><?= $mc['make'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="inline">
                <span>Model</span>
                <input type="text" name="vehicle[model]" maxlength="50" placeholder="model" required value="Yugo">
            </div>
            <div class="inline">
                <span>Price $</span>
                <input type="number" name="vehicle[price]" value="50000" min="0" max="1000000000" step="1">
            </div>
            <div class="inline">
                <span>Mileage</span>
                <input type="number" name="vehicle[mileage]" value="10000" min="0" max="1000000000" step="1">
            </div>
            <div class="inline">
                <span>Type</span>
                <select name="vehicle[type_id]">
                    <?php foreach ($typeChoices as $tc) : ?>
                        <option value="<?= $tc['id'] ?>" ><?= $tc['type'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="inline">
                <span>Class</span>
                <select name="vehicle[class_id]">
                    <?php foreach ($classChoices as $cc) : ?>
                        <option value="<?= $cc['id'] ?>"><?= $cc['class'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="inline">
                <span>Cost $</span>
                <input type="number" name="vehicle[cost]" value="1000" min="0" max="1000000000" step="1">
            </div>
            <button type="submit" name="action" value="add_vehicle">Add</button>
        </div>
    </Form>
</section>

<div style="height: 20px; " ></div>

<!-- Section of links to edit types, makes, classes -->
<section>
    <hr>
    <div class="inline flexcenter" >
        <h3>Add/Edit Attributes</h3>
    </div>
    <div class="inlinewrap flexcenter " >
        <p style="border: 1px solid black; " ><a style="padding: 8px"  href=".?page=editTwo&table=types">View/Edit Types</a></p>
        <p style="border: 1px solid black; "><a style="padding: 8px" href=".?page=editTwo&table=makes">View/Edit Makes</a></p>
        <p style="border: 1px solid black; "><a style="padding: 8px" href=".?page=editTwo&table=classes">View/Edit Classes</a></p>
    </div>
    <hr>
</section>

<?php
include('../view/footer.php');
?>