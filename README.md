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
Accordingly it’s expectable that there should be some template files in the system. Interestingly that’s correct , you can find all of the component templates in the component folder of Sculptor source under a folder of the CSS source. But for giving you a preview of the rendered components we suggest you to see the links of all Sculptor components in the below link:

[Components](https://github.com/ali-souri/sculptor/blob/master/components/COMPONENTS.md)

# What if a good developer wants to make his own Components?
That’s totally possible. You just need to make all of your templates in the appropriate template files.
These files are supposed to be written by the rules of Symphony twig template engine and with the name by the structure of below:

`Template.twig` Or `Template.thml.twig`

and the name instead of Template would be the name of your template. And then you will have to put all of your templates in an individual directory around your system in a directory and then declare the address of directory with the below method of Sculptor:

`$app->setExtraCssPath(“/path/to/your/folder”);`

#The Document Object:
Eventually there is a very important question :
What are we supposed to do if we want Sculptor to render whole HTML page?
And the answer is :
By using the Document Object which represents whole tools of generating a page. And making a new document is ridiculously easy:

`$document = $app->makeDocument();`

Now we discuss the methods of the Document Object:

## Add:
– If you want to put an element directly in the document you will just need to use the add method:

`$document->add($btn);`

this method will add the &btn element (which we have made before) directly to the document.

### – Remarkable Tip  : please be informed that the rendered html of the &btn object will be put directly in the body tag of the page.

## putIn and addIn:
– If you want to put or add an element to another element instead of body there are two Sculptor method for that, putIn and addIn:

```
$btn2=$app->makeElement("button","test2",["class"=>"btn2"]);
$btn3=$app->makeElement("button","test3",["class"=>"btn3"]);
$div1 = $app->makeElement( "div" , "" , [ "class" => "div1" , "style" => 'width:100%']);
$document($btn)->putIn($div1);
$document($btn2)->addIn($div1);
```

after execution of above code we would make three new elements and then put them into an other object in the document.

### – Remarkable Tip  : Don’t forget that the ‘putIn’ method will erase all of the previous contents of the target element and then put the other element in it , but ‘addIn’ will just add it alongside the other elements.

### – Remarkable Tip  : You can always make your own pedigree of elements by using putIn and addIn methods but please don’t forget to add the head ancestor of the whole pedigree to the document using the add method otherwise the document object won’t render the whole pedigree.

After making and adding all elements together you can render your own HTML using the render method of document:

```
$html = $document->render();
echo $html;
```

As the final part of this section , I should say you can also set your own style sheets and also scripts in the page even the external files. There are some methods for that in the Sculptor:

```
$document->addStyleURL("url");
$document->addStyle(“style_tag_string”);
```

```
$document->addScriptURL("url");
$document->addScript(“script_tag_string”);
```

# Sculptor PHP to JavaScript:
Sculptor has a very set of tools for dynamically generating JavaScript component using just pure PHP components.
This functionality can really raise the ability of more easily integration of your codes and also its coherence . Nevertheless you can make lots of client side controls on your application using just PHP components.
On the other hand it makes the JavaScript coding so more easy for PHP developers because you just need to know some basic rules of javascript.
Let’s start , first of all you have to make the JSBuilder object which is so easy:

`$JS = $app->makeJSBuilder();`

in the above line of code the $JS variable represents the JS object of Sculptor which can handle all of the JS functionalities of Sculptor.

## How to make a JS function in Sculptor:
That’s so easy , because of defineJsFunction:

`$JS->defineJsFunction("click_callback_opacity",function($input_object){$input_object->target->style->opacity= "0.5";});`

As you can see the above method accepts two inputs , the first one is the a string which will be the name of js function and the second one is a closure PHP function which will be converted to the body of js function. The converted string of the javascript function will be like this:

```
function click_callback_opacity(input_object) { 
	input_object.target.style.opacity="0.5";
}
```

and that’s a legitimate js function.
But besides of typical functions Sculptor can also convert event listeners of javascript:

## Sculptor event listener:
The main event listener between js methods is the addEventListener method so there is the corresponding equivalent of that in the sculptor:

`$JS($div1)->addEventListener("click",function($obj){$obj->target->style->visibility = "hidden";});`

This method will make the below js code after execution (and the rendering phase which will be explained to you soon):

`document.getElementById('sculptor-313704410').addEventListener ("click" ,function (obj){obj.target.style.visibility="hidden";});`

and that is a real javascript event listener implementation.

### – Remarkable Tip  : The sculptor-313704410 is the id of the considered element generated automatically by Sculptor , if you want to customize it just add the id attribute when you are creating the element.

## Sculptor jQuery:

You can use convert PHP to jQuery using sculptor because it supports most of jQuery api. Like the simple methods:

`$JS($div1)->slideToggle();`

and you can also use the jQuery event handler even with the other elements in the document:

`$JS($btn1)->on("click",function() use ($JS,$div1) {$JS($div1)->slideToggle();});`

the event listener will be converted to this:

```
$("#btn1").on("click",function () { 
	 $("#sculptor-71182252").slideToggle(); 
}); 
```

### – Remarkable Tip  : Don’t forget to set the ‘use’ key word for the function because the PHP function needs it to recognize external variables.
### – Remarkable Tip  : you can use your own string CSS selector instead of $btn1. The sculptor supports all of the CSS selectors.

After writing your codes please don’t forget to render and put your javascript in the page:

`$document->addScript($JS->render());`

and please do it before rendering the whole document.

Thank you very much
Good Luck
Ali Souri




