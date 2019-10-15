<h2>Initial Setup</h2>

<p>As this project is written in the Laravel framework please carry out the following initial steps to get yourself up and running</p>

<ol>
    <li>Rename the .env.example file to .env at the document root of your environment and fill in the necessary configurations</li>
    <li>As this application integrates the Google Maps and What3Words Api please ensure you set up the appropriate credentials for each. Once you have done this please add your secret keys to the root .env file in the following format:
        <ul>
            <li>WHAT3WORDS_API_KEY="[WHAT3WORDS_API_KEY]"</li>
            <li>GOOGLE_MAPS_API_KEY="[GOOGLE_MAPS_API_KEY]"</li>
        </ul>
    </li>
    <li>Run the following commands from the project root: 
        <ul>
            <li>php artisan key:generate</li>
            <li>composer install (this will install all php dependencies)</li>
            <li>npm install (This will install all nopde js modulkes - ** As this application uses font awesome pro you will need to install youre config key you will have if you have a valid font awesome pro license. You can still run the app without this feature, although you will not be able to see any font awesome pro icons without it **)</li>
        </ul>
    </li>
</ol>

<h3>DB Setup</h3>

<p>To setup the DB schema and populate it with the relevant data please run the following command from the document root.</p>

<ul>
    <li>php artisan migrate --seed</li>
</ul>


