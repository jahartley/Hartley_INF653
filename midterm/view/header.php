<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Midterm</title>
    <style>
        .inlinewrap{
            display:flex;
            flex-direction: row;
            gap: 10px;
            justify-items: left;
            align-items: center;
            align-content: center;
            flex-wrap: wrap;
        }
        .inline{
            display:flex;
            flex-direction: row;
            gap: 6px;
            justify-items: left;
            align-items: center;
            align-content: center;
            flex-wrap: nowrap;
        }
        .flexcenter {
            justify-content: center;
        }
        .filterbox {
            min-height: 25px;
        }
        h3 {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }
        header {
            padding: 0.75em;
            background-color: rgb(159, 159, 255);
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            flex: wrap;
        }
        table {
        border-collapse: collapse;
        }
        th, td{
            padding: 10px;
            border-bottom: 1px solid black;
        }
        td {
            width: 14%;
        }
        tr:nth-child(even) {background-color: rgb(219, 219, 252);}
    </style>
</head>

<body>
    <main>
        <header>
            <h1>Zippy Used Autos</h1>
            <h3>Call Us! 929-556-2746</h3>
        </header>