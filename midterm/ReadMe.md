# Midterm for INF653
Judson Hartley's FHSU INF653 Midterm project.

## Project Requirements
- Make a PHP webpage and backend, using an XAMPP stack, MySQL, and PHP.
- Follow MVC design pattern.
- Use more than one controller.
- Organize into separate model/view/controller folders.
- One page PDF describing challenges.
- Public Homepage
  - Display all vehicles on page load, sorted by price descending.
  - Allow users to change sort order between year or price
  - Dropdown menu to filter by make type or class, one at a time
- Admin Backend
  - Admin page at /admin/
  - List all vehicles, with option to delete vehicles.
  - pages for Add/Delete makes, types, and classes.
  - ability to add new vehicles.
  - no links from public to admin area.

Extra Credit for:  
- combined filter that can filter by make/type/class at the same time.
- admin footer menu that matches current page.

## Challenges
1. Staying with PHP. Almost everything I fought with during this project was met with "why would you use PHP for that, just use JavaScript". And having made a few JavaScript projects, I already knew all the reasons why. It was very interesting to try and make it work without JavaScript. The most obvious shortcoming is having responsive form items, like the check boxes. In hind sight they all could have been buttons, maybe changing colors when selected or not, similar to how I made the sorting buttons.
2. Good documentation on where to put the PHP Session code. There are lots of quick examples for the PHP Sessions that I needed so that the separate forms for individual vehicle row updates/deletes, sorting buttons, filter checkboxes and so on would retain the settings they had when the page reloads. PHP reloads the page on every form submission, and most solutions were "Ditch PHP, use JS to make a fetch or AJAX request". At one point everything on the Admin page was one giant form, and any button clicked would submit every data point on the whole page all at once. This did work, but the controller code looked like a nightmare. Eventually I figured out how to save and use the session store, and was able to refactor the pages back to a more common approach, with each part being its own form, a normal looking action router in the controller, and then using the session to keep things like the current SQL ORDER BY and WHERE strings so that the next page load looks the same as the last.
3. Early on I tried to set the table or column to use with the PDO bind statement, not realizing that it only worked for values. I got around this by building the SQL statement string dynamically then binding the values.
4. I really missed JavaScript's native console logging, and also NodeJS's ability to debug via a browser.
5. My PHP stack is running on a separate computer in a docker container, which I really enjoy, as there is no risk of dependency craziness with competing package requirements, and then pealing all the layers of software involved in this stack back off my computer when I am done with it. A special thanks goes to [Tomáš Jašek and his docker-xampp docker container](https://github.com/tomsik68/docker-xampp), which was very quick to start up, and already included everything I need for this class.