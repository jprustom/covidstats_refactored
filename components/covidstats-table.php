<body>
    <h1>Latest Covid Stats</h1>
        <section id="covidstats-table">
            <div id="covidstats-table__headers">
                <div class="covidstats-table__header"></div>
                <div class="covidstats-table__header">Country</div>
                <div class="covidstats-table__header">Latest Cases</div>
                <div class="covidstats-table__header">Latest Deaths</div>
            </div>
            <div id="covidstats-table__entries">
                <?php render_last_covidstats() ?>
            </div>
            
        </section>
</body>