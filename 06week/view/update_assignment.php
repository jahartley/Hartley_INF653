<?php
include('view/header.php');
?>

<!-- Section to Display Assignments -->
<section class="assignment-container">
    <h2>Update Assignment</h2>
    <?php if (!empty($assignments)) : ?>
        <?php foreach ($assignments as $assignment) : ?>
            <form action="." method="post">
                <select name="course_id" required>
                    <option value="">Please select</option>
                    <?php foreach ($courses as $course) : ?>

                        <option value="<?= $course['courseID'] ?>" <?= ($assignment['courseName'] == $course['courseName']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($course['courseName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="assignment_id" value="<?= $assignment['ID'] ?>">
                <input type="text" name="description" maxlength="120" placeholder="Description" required value="<?= $assignment['Description'] ?>">
                <button type="submit" name="action" value="update_assignment">Update</button>
            </form>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Invalid Assignment, try again.</p>
    <?php endif; ?>

</section>

<p><a href=".?action=list_assignments">View/Edit Assignments</a></p>

<?php
include('view/footer.php');
?>
