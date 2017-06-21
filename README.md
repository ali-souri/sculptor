# ![Image of Sculptor](http://ict-schools.ir/jsschool/web/images/sculptor-logo-small.png)
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

### – Remarkable Tip  : all of the mehods of Sculptor are written camel-case.

# What about the Theme? 
You can set the name of your considered theme by its predefined method:

`$app->setCssTheme("cosmo");`

The corresponding theme will be provided from the given name  . if you set bootstrap for your CSS source , the theme will be from Bootswatch themes:

[BootsWatch Themes](http://bootswatch.com/)

so you will have to choose the theme name from the themes of bootswatch. On the other hand if jquery is set as your CSS source then all the themes will gather from jquery-ui:

[jQuery Themes](http://jqueryui.com/themeroller/)

so you will have to choose the theme name from the themes of jQuery-ui themes.

# Want to make an HTML Element?
It’s so easy in Sculptor:

`$btn = $app->makeElement( "button" , "test" , [ "class"  => "btn" , "id" => "btn1"]);`

As you can see you just have to use makeElement method of the Sculptor object. This method accepts the name of HTML tag in the first input , the body text of tag in the second input and the array of attributes in the third input. However the $btn object is an Element Object of Sculptor and it’s not yet viewable as HTML. For see the HTML equivalent of the Element object you have to render the element:

`echo $btn->render();`

The result of code line ahead would be like the below HTML tag:

`<button class="btn" id="btn1" >test <!-- tag-body --> </button>`

But don’t be mad if you forget to put some attributes in the input array of makeElement method , you can add it after:

`$btn->addAttributes(["type" => "button" , "name" => "submit" ]);`

let’s see what else sculptor got for making HTML:

# Sculptor Components: 
Sculptor supports lots of HTML components of both jquery and bootstrap CSS sources and you just need to use the simple method ‘makeComponent’ for it:

`$inpgr = $app->makeComponent( "InputGroups" , [ "befor_label" => "InputGroup1:" , "name" => "test1" , "placeholder" => "Give Me A Test" ]);`

As you can see there are only two parameters for the method , which the first one is the name of component and second one is the array of data for rendering the template of component.
Accordingly it’s expectable that there should be some template files in the system. Interestingly that’s correct , you can find all of the component templates in the component folder of Sculptor source under a folder of the CSS source. But for giving you a preview of the rendered components we suggest you to see the links of all Sculptor components in the below table:
