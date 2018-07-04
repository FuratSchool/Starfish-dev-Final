<div class="tree-branch">
    <div class="tree-left">
        <input type="checkbox" name="{{ $cat->id }}" />
    </div>
    <div class="tree-body">
        <h4>{{ $cat->name }}</h4>
        @foreach($cCat as $cat->children())
            @include('modules.category', ['cat' => $cCat])
        @endforeach
    </div>
</div>