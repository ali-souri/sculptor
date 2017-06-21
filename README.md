# Sculptor
CookBook Version : 1.0.0

# What is Sculptor?
Sculptor is a set of tools for generating HTML , CSS and JavaScript dynamically using pure PHP components. This tools allow you to define elements and components and then put them in your considered hierarchy of elements and then render it to HTML.
Meanwhile this source represents a vast range of components for dynamic conversion of your PHP components to JavaScript and also jQuery components. 

# How to use it?
For using Sculptor you need to download and install it first.

## Download:
You can download the source code through composer or from this link:

[Sculptor Github](https://github.com/ali-souri/sculptor)

## Install:
After downloading don’t forget to update the composer inside of the folder to get all of the required utilities:

`#> php composer update`

## Use:
After that for using the tools of source you are only supposed to require the main file of Sculptor (or the autoload of your vendor folder):

`Require '/path/to/sculptor/Sculptor.php';`

# Develop:
All of the tools of Sculptor is accessible from the main file and you just have to instantiate the Sculptor class in the main file:

`$app = new \Sculptor\Sculptor(“bootstrap”,”jquery”);`

The first input of the constructor of class is allocated to the string of the name of considered CSS source. This variable can have a value of ‘bootstrap’ or ‘jquery’. And that means all of the components of the system will be styled by the considered source. And the second variable is allocated to JS source of the system which can be ‘pure’ (which is the default amount of this field) and also ‘jquery’. However you can use an empty constructor and then set your considered sources by the Setter methods:

```
$app = new \Sculptor\Sculptor();
$app->setCssSource("bootstrap");
$app->setJsSource("jquery");
```
