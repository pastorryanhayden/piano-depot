I've been tasked with redesiging pianodepot.com. I plan on making the site in this laravel app and making a custom CMS for it's management. Here is what I need you to do:
1. Anylize the current pianodepot site (or the wayback machine version if the site is unavailable) to determine it's existing content.
2. Download the html and images of the current site to a folder on my machine.
3. In notes/tasks.md write a todo list for designing the new site, from sitemap to wireframes.  Follow website design best practices.
4. In that same file, add a todo list for creating the new site and cms.  

Here is my development philosophy:
1. As much as possible, I want to use old-school server-rendered designs with CRUD controllers.
2. I do not like custom controller methods.  Either use a resource controller or make a single method invokable controller.
3. For light interactivity (showing and hiding things) we can use Alpine.js.  For anything more we can use Turbo and Stimulus.
4. For a simple website like this, a sqlite file is fine.
