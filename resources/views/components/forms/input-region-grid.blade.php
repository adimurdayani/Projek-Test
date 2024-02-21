@push('style')
  
  <style>
    .parent-search-region {
      position: relative;
    }

    .input-search-region {
      position: absolute;
      border: 1px solid blue;
      width: 95%;
      padding: 0;
      max-height: 150px;
      overflow: scroll;
    }

    .input-search-region p {
      cursor: pointer;
      background-color: white;
      color: blue;
      padding: 5px;
      margin: 0;
    }
    
    .input-search-region p:hover {
      cursor: pointer;
      background-color: blue;
      color: white;
    }
  </style>

@endpush

<div class="row align-items-center my-2">
  <div class="col-md-4">
    <label>Daerah</label>
  </div>
  <div class="col-md-6 parent-search-region">
    <input autocomplete="off" type="text" class="form-control" name="region_name" value="{{ $value ?? '' }}" placeholder="Cari daerah...">
    <input type="hidden" name="region_id" value="{{ $regionId ?? '' }}">
    <div class="input-search-region d-none" id="listRegionSearch">
    </div>
    <div></div>
  </div>
</div>