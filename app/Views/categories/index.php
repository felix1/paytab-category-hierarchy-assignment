<?php
?>
<section class="categories">
    <h1> Selecting Category with Simple cache (Saving requests)</h1>
        <select name='categoris' class='custom-select' id='1' onchange='getSubCategory(this)'>
            <option value='0'>Please Select Your Category</option>
            <?php
            foreach ($categories as $key => $category) {
                        print("
                        <option value='$category->id'>
                            $category->title
                        </option>");
            }?>
        </select>
        <!-- div that hold all sub categories -->
        <div class="subcategories">
            
        </div>
</section>
<?php
/*
    # Facts:
        * All Options in one select are the same Parent id
        * I need to delete children not parent when select changed
        * I need to loop backward nor forward to delete any select under the changed one
        * I need to chach response what a bout normal Array its 
            fast and no need for async data with server  and delete when user refresh !
*/      
?>
<script>
// Node Array for saving the parent Id and his children
let nodes = Array();
// Function called when any select statment change with self reference for this select
/*
    * this function get sub categorires and cache them
    @param select object
     @return null
*/
const getSubCategory = (element)=> {
    // assign select to varibale to save time
    const select = $(element);
    //get selected category
    let level = parseInt(select.val());
    //set id of this select as id of selected category
    select.attr('id', level);
    //get all subcategories loaded
    let oldSelects = $(".subcategories").children();
    // for loop backward and delete every element till you found the changed one in hierarchy 
    for(let  i = oldSelects.length-1; i >= 0; i --){
        if(oldSelects[i].id == level)
            break; // Loop Until you found the changed Select and delete all under it
        oldSelects[i].remove();
    }
    // if user select Please Select Your Category then do nothing after delete all other select under it 
    if($(element).val() == 0)
        return false;
    // filter nodes array and search for the category that use select
    node = nodes.filter(node => node.id == level);
    //if there is node mean the user reselect this category again 
    if(node.length){
        // draw the selected category from cache
        if(node[0].children.length)
            drawselectBox(node[0].children);
    }else{//  first time user select this category 
        // create new node initialize with id this category 
        let node = {id : level };
        // send get request to retrive sub categories of selected caegory 
        $.get(`categories/${level}`, (data, textStatus, jqXHR)=>{
            // if request Success
            if(textStatus == 'success'){
                // add sub categories to node
                node.children = data;
                // save this node in cache for comming request
                nodes.push(node);
                // if there is no children then do nothing
                if(data.length <= 0)
                    return false;
                // else draw select box with sub categories
                drawselectBox(data);
            }else{// there an Error then check it 
                alert('There Is an Error Check Your Connection please');
            }
        });
    }
    
}

// this function simply draw new select with option sub categories 
const drawselectBox = (categories)=>{
    let options = '';
    // loop for sub categories and add to option string
    categories.forEach(category => {
        options += `<option value="${category.id}" >${category.title}</option>`;
    });
    // create select statment with this options
    let select = `<select name='categoris' class='custom-select' onchange='getSubCategory(this)'>
                    <option value='0'>Please Select Your Category</option>
                    ${options}
            </select>`;
    // append it to subcategories div 
    $(".subcategories").append(select);
}
</script>
