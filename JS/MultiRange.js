document.addEventListener("DOMContentLoaded", () => {
    let sliders = document.getElementsByClassName('multi-range-slider');

    for(let i = 0; i < sliders.length; i++){
        let sliderContainer = $(sliders[i]).parent('div');
        let multiRange = $(sliderContainer).parent('div');

        let beginRange = $(multiRange).find('input[type=number].begin-range');
        let endRange = $(multiRange).find('input[type=number].end-range');

        let min = parseFloat($(beginRange).attr('min'));
        let max = parseFloat($(endRange).attr('max'));

        console.log("Диапазон №" + i + ": {Начальный: min - " + $(beginRange).attr('min') + " value - " + $(beginRange).attr('value') + " max - " + $(beginRange).attr('max') + "} {Конечный: min - " + $(endRange).attr('min') + " value - " + $(endRange).attr('value') + " max - " + $(endRange).attr('max') + "}");

        if(min != max){
            noUiSlider.create(sliders[i], {
                start: [min, max],
                tooltips: false,
                connect: true,
                range: {
                    'min': min,
                    'max': max
                }
            });

            $(beginRange).bind('input', function () {
                sliders[i].noUiSlider.set([this.value, null]);
            });

            $(endRange).bind('input', function () {
                sliders[i].noUiSlider.set([null, this.value]);
            });

            sliders[i].noUiSlider.on('update', (values, handle) => {
                console.log(values[0] + ", " + values[1]);

                $(beginRange).attr('value', parseFloat(values[0]));
                $(endRange).attr('value', parseFloat(values[1]));
            });

            sliders[i].noUiSlider.on('slide', (values, handle) => {
                $(beginRange).val(parseFloat(values[0]));
                $(endRange).val(parseFloat(values[1]));
            });
        }
    }
});