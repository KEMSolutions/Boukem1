<?php
class TemporaryOperationCommand extends CConsoleCommand
{
	
    public function getHelp()
    {
        echo "Execute the queued product operations. Can take one 'limit' argument. Defaults to 1 operation.";
    }

    public function run($args)
    {
		ignore_user_abort(true);
		set_time_limit(0);
		
		
		
		
		$dataProvider=new CActiveDataProvider('Category', array(
		    'criteria'=>array(
				'order'=>'id ASC',
		    ),
			'pagination'=>false,
		));
		
		foreach ($dataProvider->getData() as $category) {
			
			echo $category->name;
			
			
		}
		
		
    }
}
?>