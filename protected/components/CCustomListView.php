<?php
/**
 * Renders a perfectly normal CListView but with a 'itemsHtmlOptions' parameter allowing to add an ID (or any other HtmlOption) to the items div. Used in the category view to add 'id'=>'masonryWr'.
 */
Yii::import("zii.widgets.CListView");

class CCustomListView extends CListView
{

    public $itemsHtmlOptions;
    /**
     * Renders the data item list.
     */
    public function renderItems()
    {
        echo CHtml::openTag($this->itemsTagName, array_merge(array('class'=>$this->itemsCssClass), $this->itemsHtmlOptions))."\n";
        $data=$this->dataProvider->getData();
        if(($n=count($data))>0)
        {
            $owner=$this->getOwner();
            $viewFile=$owner->getViewFile($this->itemView);
            $j=0;
            foreach($data as $i=>$item)
            {
                $data=$this->viewData;
                $data['index']=$i;
                $data['data']=$item;
                $data['widget']=$this;
                $owner->renderFile($viewFile,$data);
                if($j++ < $n-1)
                    echo $this->separator;
            }
        }
        else
            $this->renderEmptyText();
        echo CHtml::closeTag($this->itemsTagName);
    }
}