<div class="row">
    @foreach($summary as $card)
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-{{ $card['color'] === 'olive' ? 'success' : $card['color'] }}">
                    <i class="{{ $card['icon'] }}"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ $card['label'] }}</span>
                    <span class="info-box-number">{{ number_format($card['count']) }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
