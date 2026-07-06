<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lionel Messi - Tribute Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5 mb-5">
  
      <h1>My First Web Page</h1>
      <h2>A quick look at basic HTML</h2>

      <hr> 
      <p>This is a standard paragraph. HTML tags tell the browser how to structure and display your content.</p>

      <!-- Used <b> and <i> here as requested by the assignment -->
      <p>You can make text <b>bold</b> to make it stand out, or use <i>italics</i> for emphasis. We can also use a <span class="text-primary fw-bold">span tag</span> to color specific words without breaking the line!</p>

      <h3>Things I am learning:</h3>
      <!-- Unordered List -->
      <ul>
        <li>HTML Tags</li>
        <li>Bootstrap Classes</li>
        <li>PHP Logic</li>
      </ul>

      <p>If you want to read more about tags, <a href="https://www.w3schools.com/html/" target="_blank">visit this HTML tutorial</a>.</p>

      <hr class="my-5">
  
      <h2>Adding a Local Image</h2>
      <p>Here is an image loaded directly from my computer:</p>

      <!-- Media: Image with alt text -->
      <img src="messi.jpeg" class="img-fluid w-50 rounded shadow" alt="Lionel Messi celebrating a goal">

      <p class="mt-3 fs-5">
        Lionel Messi is a famous football player from Argentina. Many people believe he is the greatest player of all time. He is known for his incredible dribbling skills, passing, and scoring lots of amazing goals. He also won the World Cup with his country.
      </p>

      <h3>Clubs He Has Played For:</h3>
      <!-- Ordered List added -->
      <ol>
        <li>FC Barcelona (Spain)</li>
        <li>Paris Saint-Germain (France)</li>
        <li>Inter Miami CF (USA)</li>
      </ol>

      <hr class="my-5">

      <!-- Data Display: Table added -->
      <h2>Career Statistics (Club Level)</h2>
      <p>Here is a quick look at his incredible goal-scoring record for his primary clubs:</p>
      
      <table class="table table-bordered table-striped text-center w-75">
        <thead class="table-dark">
          <tr>
            <th>Club</th>
            <th>Appearances</th>
            <th>Goals</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>FC Barcelona</td>
            <td>778</td>
            <td>672</td>
          </tr>
          <tr>
            <td>Paris Saint-Germain</td>
            <td>75</td>
            <td>32</td>
          </tr>
        </tbody>
      </table>

      <hr class="my-5">

      <!-- User Input: Form added -->
      <h2>Join the Messi Fan Club</h2>
      <p>Fill out this form to connect with other fans worldwide!</p>

      <form action="#" method="get" class="border p-4 rounded bg-light">
        
        <!-- Text Input -->
        <div class="mb-3">
          <label for="fanName" class="form-label">Your Name:</label>
          <input type="text" id="fanName" name="fanName" class="form-control" required>
        </div>

        <!-- Dropdown (Select) -->
        <div class="mb-3">
          <label for="favEra" class="form-label">Your Favorite Messi Era:</label>
          <select id="favEra" name="favEra" class="form-select">
            <option value="barca">Barcelona Era</option>
            <option value="argentina">Argentina World Cup Era</option>
            <option value="miami">Inter Miami Era</option>
          </select>
        </div>

        <!-- Radio Buttons -->
        <div class="mb-3">
          <label class="form-label d-block">Who is the GOAT?</label>
          <div class="form-check form-check-inline">
            <input type="radio" id="messiGOAT" name="goat" value="messi" class="form-check-input" checked>
            <label for="messiGOAT" class="form-check-label">Lionel Messi</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" id="otherGOAT" name="goat" value="other" class="form-check-input">
            <label for="otherGOAT" class="form-check-label">Someone else (Incorrect)</label>
          </div>
        </div>

        <!-- Textarea -->
        <div class="mb-3">
          <label for="bestMoment" class="form-label">What is your favorite Messi moment?</label>
          <textarea id="bestMoment" name="bestMoment" rows="3" class="form-control"></textarea>
        </div>

        <!-- File Upload -->
        <div class="mb-3">
          <label for="fanArt" class="form-label">Upload Fan Art (Optional):</label>
          <input type="file" id="fanArt" name="fanArt" class="form-control">
        </div>

        <!-- Checkbox -->
        <div class="form-check mb-4">
          <input type="checkbox" id="newsletter" name="newsletter" value="subscribe" class="form-check-input">
          <label for="newsletter" class="form-check-label">Subscribe to the monthly newsletter</label>
        </div>

        <!-- Submit Button -->
        <input type="submit" class="btn btn-primary" value="Submit Registration">
      </form>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>