
const { registerBlockType } = wp.blocks; 


registerBlockType(
    'gutenberg-blocks-sample/block-simple',
    {
	    title: 'Simple Red Title', 
	    icon: 'universal-access-alt', 
	    category: 'common',
    
        edit ( {className} ) {
		    return (
                <p className={className}>This custom block will create a red title</p>
            );
        },
 
        save ( ) {
            const demo = () =>{
                return 100
            }
            return (
                <h1>The custom red title {demo()} :) </h1>
            );
        },
    } 
);