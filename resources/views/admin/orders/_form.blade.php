<div class="form-group">
    {!! Form::label('Client','Cliente: ') !!}
    {!! Form::select('client_id',$client ,null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Status','Status: ') !!}
    {!! Form::select('status',$list_status ,null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('DeliveryMan','Entregador: ') !!}
    {!! Form::select('user_deliveryman_id',$deliveryman, null, ['class'=>'form-control']) !!}
</div>
