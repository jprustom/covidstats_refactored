<body>
    <h1>Add Cases</h1>
    <form id="add-stats" action=<?php echo($path_to_utils.'insert.php') ?>  method='post'>
        <div id='date'>
            <label for='date'>Date:</label>
            <input required name='date' type='datetime-local'/>
        </div>
        <div id='country'>
            <label for='country'>Country:</label>
            <?php renderCountriesSelect()?>
        </div>
        <div id='newCases'>
            <label for='newCases'>Number of new cases:</label>
            <input name='newCases' required min=0 type='number'/>
        </div>
        <div id='newDeaths'>
            <label for='newDeaths'>Number of new deaths:</label>
            <input name='newDeaths' required min=0 type='number'/>
        </div>
        <button type='submit'>OK</button>
    </form>
</body>