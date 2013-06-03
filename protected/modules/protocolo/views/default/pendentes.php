<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

$this->breadcrumbs=array(
	'Protocolo',
);

$this->menu=array(
	array('label'=>'Protocolar', 'url'=>array('create'), 'visible'=>Yii::app()->user->checkAccess('Protocolista')),
	array('label'=>'Pesquisar', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::app()->getModule('user')->user()->profile->unidade->nome; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pendentes-grid',
	'dataProvider'=>$pendentesProvider,
	'columns'=>array(
		'protocolo_id',
		'or.sigla',
		'or_datahora',
		'de.sigla',
		'de_datahora',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{receber}{tramitar}{imprimir}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{view}',
			'buttons'=>array(
				'view'=>array(
					'url'=>'Yii::app()->createUrl("/protocolo/default/view", array("id"=>$data->protocolo_id))',
				),
				'receber'=>array(
					'label'=>'Receber',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/receber.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/receber", array("id"=>$data->id))',
					'options'=>array('title'=>'Recebimento','onClick'=>"if(confirm('Confirma o recebimento?'))return true;else return false"),
					'visible'=>'$data->destino==Yii::app()->getModule("user")->user()->unidade && !isset($data->de_datahora)',
				),
				'tramitar'=>array(
					'label'=>'Tramitar',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/tramitar.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/move", array("id"=>$data->protocolo_id))',
					'visible'=>'isset($data->de_datahora)',
				),
				'imprimir'=>array(
					'label'=>'Imprimir',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/imprimir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/print", array("id"=>$data->protocolo_id))',
					'visible'=>'$data->origem==Yii::app()->getModule("user")->user()->unidade && !isset($data->de_datahora)',
				),
			),
		),
	),
)); ?>