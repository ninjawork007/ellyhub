@extends('layouts.admin')
@section('content')
<div class="page-header no-gutters">
  <div class="d-md-flex align-items-center justify-content-between">
    <div class="align-items-center">
      <h2 class="header-title">Home Page Settings</h2>
    </div>
    <div class="align-items-center">
      <div class="d-md-flex align-items-center justify-content-between">
        <div class="align-items-center p-10">
          <b class="text-secondary">Create New Section</b>
        </div>
        <div class="align-items-center p-10">
          <select class="form-control" id="status" name="status">
            <option value="">Select Section</option>
            <option value="0">Banners Section</option>
            <option value="1">Products Section</option>
          </select>
        </div>
        <div class="align-items-center p-10">
          <select class="form-control" id="status" name="status">
            <option value="">Select Banner</option>
            <option value="0">Slider Banners</option>
            <option value="1">4 Cols Banners</option>
            <option value="1">3 Cols Banners</option>
            <option value="1">2 Cols Banners</option>
            <option value="1">Single Banner</option>
          </select>
        </div>
        <div class="align-items-center p-10">
          <a href="javascript:;" class="btn btn-secondary">Add Section</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="accordion home-accordion-section" id="homesection-accordion">
  <div class="card banner-slider-section">
    <div class="card-header">
      <h5 class="card-title">
        <a data-toggle="collapse" href="#collapseSection1">
          <span>Slider Banners Section</span>
        </a>
      </h5>
    </div>
    <div id="collapseSection1" class="collapse show" data-parent="#homesection-accordion">
      <div class="card-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>URL</th>
              <th>Status </th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <a href="https://multivendor.amrkart.com/public/uploads/banner1620120952.jpg" data-fancybox="slider-image">
                  <img src="https://multivendor.amrkart.com/public/uploads/banner1620120952.jpg" alt="image" class="bg-light" style="width:100px">
                </a>
              </td>
              <td>Slider Image 1</td>
              <td>https://multivendor.amrkart.com/category/12</td>
              <td>
                <div class="switch m-r-10">
                  <input type="checkbox" id="switch-1" checked="">
                  <label for="switch-1"></label>
                </div>
              </td>
              <td>
                <div>
                  <a href="#" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></a>
                  <a href="#" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></a>
                  <a href="javascript:;" class="btn btn-outline-danger btn-sm" onclick="delete_row('12','banner')"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <a href="https://multivendor.amrkart.com/public/uploads/banner1620129352.jpg" data-fancybox="slider-image">
                  <img src="https://multivendor.amrkart.com/public/uploads/banner1620129352.jpg" alt="image" class="bg-light" style="width:100px">
                </a>
              </td>
              <td>Slider Image 2</td>
              <td>https://multivendor.amrkart.com/category/12</td>
              <td>
                <div class="switch m-r-10">
                  <input type="checkbox" id="switch-2" checked="">
                  <label for="switch-2"></label>
                </div>
              </td>
              <td>
                <div>
                  <a href="#" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></a>
                  <a href="#" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i></a>
                  <a href="javascript:;" class="btn btn-outline-danger btn-sm" onclick="delete_row('12','banner')"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="section-bottom m-t-15">
          <div class="text-right">
            <a href="#" class="btn btn-success"><i class="fa fa-plus"></i> Add New Slider</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card 4-col-banner-section">
    <div class="card-header">
      <h5 class="card-title">
        <a class="collapsed" data-toggle="collapse" href="#collapseSection2">
          <span>4 Cols Banners Section</span>
        </a>
      </h5>
    </div>
    <div id="collapseSection2" class="collapse" data-parent="#homesection-accordion">
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="text-center">
              <h4>Image 1</h4>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="text-center">
              <h4>Image 2</h4>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="text-center">
              <h4>Image 3</h4>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="text-center">
              <h4>Image 4</h4>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card 3-col-banner-section">
    <div class="card-header">
      <h5 class="card-title">
        <a class="collapsed" data-toggle="collapse" href="#collapseSection3">
          <span>3 Cols Banners Section</span>
        </a>
      </h5>
    </div>
    <div id="collapseSection3" class="collapse" data-parent="#homesection-accordion">
      <div class="card-body">
        ...
      </div>
    </div>
  </div>
  <div class="card 2-col-banner-section">
    <div class="card-header">
      <h5 class="card-title">
        <a class="collapsed" data-toggle="collapse" href="#collapseSection4">
          <span>2 Cols Banners Section</span>
        </a>
      </h5>
    </div>
    <div id="collapseSection4" class="collapse" data-parent="#homesection-accordion">
      <div class="card-body">
        ...
      </div>
    </div>
  </div>
  <div class="card single-col-banner-section">
    <div class="card-header">
      <h5 class="card-title">
        <a class="collapsed" data-toggle="collapse" href="#collapseSection5">
          <span>Single Banner Section</span>
        </a>
      </h5>
    </div>
    <div id="collapseSection5" class="collapse" data-parent="#homesection-accordion">
      <div class="card-body">
        ...
      </div>
    </div>
  </div>
</div>

@endsection