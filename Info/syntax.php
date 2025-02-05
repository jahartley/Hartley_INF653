<!DOCTYPE html>
<html>
<body>
<h1>PHP syntax</h1>
<h2>Case sensitivity</h2>
All PHP keywords, classes, functions, user-defined functions ARE NOT case sensitive

<h2>Comments</h2>
use // or /* */ comments. The # also works but only at the beginning of a line.

<h2>Strings</h2>
<h3>Single vs Double Quotes</h3>
strings with single quotes do not expand variables, i.e. 'Hello $txt' = Hello $txt. Double quotes automatically expand, i.e. "Hello $txt" = Hello World.
<h3>Concatenation</h3>
Concatenate strings using , or .
<h3>Escape Character</h3>
use the \ for escaping characters in strings. use \$ when using double quote strings to prevent the $ from being treated as the beginning of a variable.
<ul>
    <li>\' to escape ' in single quote strings</li>
    <li>\" to escape " in double quote strings</li>
    <li>\\ to escape \</li>
    <li>\$ to escape $ in double quote strings</li>
    <li>\n newline</li>
    <li>\t tab</li>
</ul>
<h2>Short Echo</h2>
The short echo <code>&lt;?= ?&gt;</code> echo's whatever is between the = and the ?, no <code>&lt;?php</code> required.

<h2>Variables</h2>
declared with $, no explicit types, CASE SENSITIVE, start with letter or _, name can have A-z, 0-9, _.
No ERRORS FOR USING UNDEFINED VARIABLES...
<h3>Debugging Variables</h3>
use var_dump($variable); to dump all variable info.
</body>
</html>