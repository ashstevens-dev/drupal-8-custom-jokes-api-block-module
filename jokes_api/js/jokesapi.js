/**
 * @file
 * Jokes API js.
 */
(function (Drupal, drupalSettings) {

  // pull in the needed values and set the vars
  const output_limit = drupalSettings.apiconfig.config.output_limit;
  const api_url = drupalSettings.apiconfig.apiUrl;
  const jokeCont = document.getElementById('jokes');

  // use the fetch API to pull in the feed data
  // reject the promise if an ok (200-299) response isn't received
  fetch(api_url, {method: 'get'})
    .then((response) => {

      if (response.ok) {

        return response.json();
      
      } else if(response.status === 404) {

        return Promise.reject('404 - URL not found!');
      
      } else {

        return Promise.reject(response.status);

      }

    })
    .then((data) => {

        if (data.jokes) {

          // set the object to a variable
          const jokeObj = data.jokes;

          // loop through the jokes object
          for (const childJoke of jokeObj) {

            let jokesTxt = document.createElement('p');
            // set the innerHTML of the p element to the data
            jokesTxt.textContent += childJoke.joke;
            jokeCont.appendChild(jokesTxt);

          }

        } else {

          const jokeTxt = document.createElement('p');
          // set the innerHTML of the p element to the data
          jokeTxt.textContent = data.joke;
          jokeCont.appendChild(jokeTxt);

        }
    
  })
  .catch(error => console.log(error));
        
})(Drupal, drupalSettings);
