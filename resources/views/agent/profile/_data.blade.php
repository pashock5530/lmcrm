<div class="row">
    <div class="col-sm-5">
        <table class="table table-bordered">
            <tbody>
                @if(!empty($data))
                    <tr>
                        <td>icon</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>date</td>
                        <td>{!! $data->date !!}</td>
                    </tr>
                    <tr>
                        <td>name</td>
                        <td>{!! $data->name !!}</td>
                    </tr>
                    <tr>
                        <td>phone</td>
                        <td>{!! $data->customer->phone !!}</td>
                    </tr>
                    <tr>
                        <td>email</td>
                        <td>{!! $data->email !!}</td>
                    </tr>
                    @foreach ($data->sphere_attributes as $attribute)
                            <tr>
                                <td>{!! $attribute->label !!}</td>
                                <td>
                                    @foreach ($attribute->options()->get() as $option)
                                    <?php

//var_dump($masks);
//                                            echo $mask->getTableName();
//                                            echo $attribute->sphere_id;
                                            //var_dump($mask->findShortMask(7));
                                        ?>
                                        @if(isset($masks[$option->id]) && $masks[$option->id] === 1)
                                            <p>{!! $option->value !!}</p>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2">empty</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>