<div style="max-width:730px;margin: auto;padding: 20px;background:#f4f8fb;font-family:arial;">
	<div style="background:white;border: solid 1px #ebebeb;padding: 15px;padding-top:8px;">
		<div style="padding-bottom: 10px;margin-bottom: 10px;border-bottom: solid 1px #ebebeb;display:flex;">
			<div style="font-size:18px; width:calc(100% - 60px);padding-top: 6px;">
				Xin chào: <strong style="color:#7e7e7e">{{$mainName}}</strong>
			</div>
            @php
                $itemImage = SettingHelper::getSetting('logo');
                $itemImageShow = new \StdClass;
                $itemImageShow->img = $itemImage ?? null;
            @endphp
            @if ($itemImageShow->img != '')
                <div style="width: 60px;">
                    <img src="{{url()->to('/')}}/{%IMGV2.itemImageShow.img.-1%}" width="60px">
                </div>
            @endif
		</div>
		@yield('content')
		<p style="text-align:right;margin-bottom: 0px;color:#969696;font-style: italic;font-size: 14px;">Ngày gửi: <strong>{{now()->format('d/m/Y H:i:s')}}</strong></p>
	</div>
	<div style="padding:10px;background:#f9f9f9;margin-top: 10px;border: solid 1px #ebebeb;">
		<div style="font-size:14px;text-align:center">
			<span style="display:block;margin-bottom: 5px;">{[hotline]} - {[email]}</span>
			<span style="display:block;margin-bottom: 5px;">Địa chỉ: {[address]}</span>
		</div>
	</div>
	<span style="font-size:15px;color:#f8f9fa;display:block;text-align:center;background: #343a40;padding: 8px;">{[copy_right]}</span>
</div>