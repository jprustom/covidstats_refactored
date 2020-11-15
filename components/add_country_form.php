<body>
    <h1>Please enter below the country to be added</h1>
    <form method="post" enctype="multipart/form-data" action="../utils/country_insert.php">
        <input required name="countryFlag" type="file"/>
        <button id="uploadFlagBtn">Upload Country Flag</button>
        <label for="countryName">Country Name:</label>
        <input required name="countryName" type="text"/>
        <button name="submit" type="submit">OK</button>
    </form>
    <script>
        const originalUploadFlagBtn=document.querySelector('form>input');
        const uploadFlagBtn=document.getElementById('uploadFlagBtn');
        uploadFlagBtn.addEventListener('click',(event)=>{
            event.preventDefault();
            originalUploadFlagBtn.click();
            });
    </script>
</body>