# Load the ILGA Invoice Template

Ilga has a dual language invoice template (English and Spanish). The chosen language is
dependent on the registered preferred communicaton language of the contact that receives the template

##

The html code of the template is found at `resources/invoice.html`


## Smarty Coding

Capture the language of the contact with:

    {capture assign=lang}{contact.preferred_language}{/capture}
    
And put the following if-then-else construct for the two langauges.    
    
    {if $lang eq "es_ES"}
       {* everything Spanish *}
    {else}
       {* everything Non Spanish (English *}
    {/if}       

## Loading 

    cv api MessageTemplate.loadinvoice
       
or

    drush cvapi MessageTemplate.loadinvoice
    
From the user interface you can use the API-Explorer    

       