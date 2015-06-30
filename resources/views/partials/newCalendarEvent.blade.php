<div>
    <form action="{{route('calendarAddEvent')}}" method="post">
        <legend>Ajouter un évènement</legend>
        <div class="form-group">
            <p id="echoDate1"></p>
            <p id="echoDate2"></p>
        </div>
        <div class="form-group @if($errors->has('title')) has-error @endif">
            <label for="title">Titre</label>
            <input type="text" class="form-control" placeholder="Titre" name="title" id="title"
                   value="{{old('title')}}"/>
            @if ($errors->has('title'))
                <p class="help-block">{{$errors->first('title')}}</p>
            @endif
        </div>

        <div class="form-group @if($errors->has('start')) has-error @endif">
            <label for="start">Début</label>

            <div class='input-group date' id="startPicker">
                <input name="start" placeholder="Début" id="start" type='text' class="form-control"/>

                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            @if ($errors->has('start'))
                <p class="help-block">{{$errors->first('start')}}</p>
            @endif
        </div>

        <div class="form-group @if($errors->has('end')) has-error @endif">
            <label for="end">Fin</label>

            <div class='input-group date' id="endPicker">
                <input name="end" placeholder="Fin" id="end" type='text' class="form-control"/>

                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
            @if ($errors->has('end'))
                <p class="help-block">{{$errors->first('end')}}</p>
            @endif
        </div>

        <div class="form-group @if($errors->has('color')) has-error @endif">
            <label for="color">Couleur</label>
            <input type="text" class="form-control" placeholder="Couleur" name="color" id="color"
                   value="#FF0000"/>
            @if ($errors->has('color'))
                <p class="help-block">{{$errors->first('color')}}</p>
            @endif
        </div>

        <input type="hidden" id="timezoneInput" name="timezone"/>
        <input type="hidden" name="_token" value="{!!csrf_token()!!}"/>
        <button type="submit" class="btn btn-primary pull-right">Ajouter l'évènement</button>
    </form>
</div>
<div class="clearfix"></div>