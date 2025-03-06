<?php
include('view/header.php');
var_dump($course);
?>

<!-- Section to update a course -->
<section class="assignment-container">
    <h2>Update Course</h2>
    <?php if (!empty($course)) : ?>
        <form action="." method="post">
            <input type="hidden" name="course_id" value="<?= $course['courseID'] ?>">
            <input type="text" name="course_name" maxlength="50" placeholder="Course Name" required value="<?= $course['courseName'] ?>">
            <button type="submit" name="action" value="update_course">Update</button>
        </form>
    <?php else : ?>
        <p>Invalid Course, try again.</p>
    <?php endif; ?>

</section>

<p><a href=".?action=list_courses">View/Edit Courses</a></p>

<?php
include('view/footer.php');
?>
