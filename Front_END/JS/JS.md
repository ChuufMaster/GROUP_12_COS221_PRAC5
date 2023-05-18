# JavaScript

This file should mainly contain folders relating to specific JS classes or functions

## General Practices

1. If a JS function can be split up into smaller functions which are called in a master functions then do so
2. Name everything as descriptively as possible so that anyone can tell what a variables purpose and what a function does
   1. **Examples**
      1. If you have a function that makes an API request that expects a return or outputs something specific like wineries, Name it API_Request_Wineries()
   2. If a function gets lone and has a lot of nesting extract a lot of the blocks of code into their own functions
      1. A function called API_Request_Wineries has a lot of if statements to tell the details about the winery
      2. Take each if statement and make it its own function eg: 
         1. Consider "if(winery.location == 'italy')" 
         2. Should become "is_winery_location(winery, country)" which returns what ever you need and contains everything in the if statement