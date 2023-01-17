<span class="less-text">
    @php
        $description = $product->description;
            if (strlen($description) > 100) {
                 $description = substr($description , 0, 100);

                 $description = substr($description,0, strrpos($description,' '));

                 echo $description = $description." <a class='text-secondary has-read-more' href='#'>".__('Read More...')."</a>";
             }
    @endphp
</span>
<span class="full-text d-none">
    {{ $product->description }} <a class='text-secondary has-read-less' href='#'>{{ __('Read Less') }}</a>
</span>
