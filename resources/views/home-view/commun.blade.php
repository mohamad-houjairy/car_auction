<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="CSS/homecss.css"/>
    <link href="{{ asset('css/homecss.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet"><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
 
    <style>
      body{
        font-family:"Varela Round", serif;
      }
    </style>
</head>
  <body>
@yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
      // Smooth scroll to section
      function scrollToSection(event) {
          event.preventDefault(); // Prevent the default anchor behavior
          const targetId = event.target.getAttribute('href'); // Get the target ID from the href
          const targetElement = document.querySelector(targetId); // Find the target element by ID
  
          if (targetElement) {
              // Scroll to the target element smoothly
              targetElement.scrollIntoView({
                  behavior: 'smooth',
                  block: 'start',
              });
          }
      }
  
      // Attach the function to all nav links with # in href
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
          anchor.addEventListener('click', scrollToSection);
      });
  </script>
  
  </body>
</html>