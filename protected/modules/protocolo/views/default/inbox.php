<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

$this->breadcrumbs=array(
	'Protocolo',
);

$this->menu=array(
	array('label'=>'Protocolar', 'url'=>array('protocolar'), 'visible'=>Yii::app()->user->checkAccess('Protocolista')),
	array('label'=>'Pesquisar', 'url'=>array('pesquisar')),
);
?>

<style>
.grid-view .button-column img
{
	border: 0;
	padding-right: 4px;
}
</style>

<h1><?php echo Yii::app()->getModule('user')->user()->profile->unidade->nome; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'protocolados-grid',
	'dataProvider'=>$protocolo->searchPendentes(),
	'filter'=>$protocolo,
	'columns'=>array(
		'protocolo',
		'documento',
		'assunto',
		'datahora',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{tramitar}{view}',
			'buttons'=>array(
				'view'=>array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/exibir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/protocolo", array("id"=>$data->id))',
				),
				'tramitar'=>array(
					'label'=>'Tramitar',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/tramitar.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/tramitar", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pendentes-grid',
	'dataProvider'=>$tramitacao->searchPendentes(),
	'filter'=>$tramitacao,
	'columns'=>array(
		array(
			'class'=>'DataColumn',
			'name'=>'_protocolo',
			'value'=>'$data->pr->protocolo',
			'evaluateHtmlOptions'=>true,
			'htmlOptions'=>array('title'=>'"{$data->pr->documento}"'),
		),
		array(
			'name'=>'origem',
			'value'=>'$data->or->sigla',
			'filter'=>Unidade::model()->listAll(),
		),
		'or_datahora',
		array(
			'name'=>'destino',
			'value'=>'$data->de->sigla',
			'filter'=>Unidade::model()->listAll(),
		),
		'de_datahora',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{receber}{tramitar}{update}{imprimir}{view}',
			'buttons'=>array(
				'view'=>array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/exibir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/protocolo", array("id"=>$data->protocolo_id))',
				),
				'receber'=>array(
					'label'=>'Receber',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/receber.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/receber", array("id"=>$data->id))',
					'options'=>array('title'=>'Receber','onClick'=>"if(confirm('Confirma o recebimento?'))return true;else return false"),
					'visible'=>'$data->destino==Yii::app()->getModule("user")->user()->unidade && !isset($data->de_datahora)',
				),
				'tramitar'=>array(
					'label'=>'Tramitar',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/tramitar.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/tramitar", array("id"=>$data->protocolo_id))',
					'visible'=>'isset($data->de_datahora) && Yii::app()->user->checkAccess("Tramitador")',
				),
				'imprimir'=>array(
					'label'=>'Imprimir',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/imprimir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/imprimir", array("id"=>$data->id))',
					'visible'=>'$data->origem==Yii::app()->getModule("user")->user()->unidade && !isset($data->de_datahora)',
				),
				'update'=>array(
					'label'=>'Editar',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/editar.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/destinar", array("id"=>$data->id))',
					'visible'=>'$data->origem==Yii::app()->getModule("user")->user()->unidade && !isset($data->de_datahora)',
				),
			),
		),
	),
)); ?>