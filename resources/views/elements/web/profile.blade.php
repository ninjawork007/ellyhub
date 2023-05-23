<?php echo check_logged_user();?>
<div class="dashboard-group">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="user-dt">
                            <div class="user-img">
                                <?php if(!$user['avatar']){ ?>
                                <img src="{{url('public/assets/website/images/avatar/img-5.jpg')}}" alt="profile">
                            <?php }else{ ?>
                                <img src="{{url('public/'.$user['avatar'])}}" alt="profile">
                            <?php } ?>
                                <form class="img-add" id="formz" enctype="multipart/form-data" method="post" action="{{route('upload_user_image')}}">
                                    @csrf
                                    <input type="file" id="file" name="profile">
                                    <label for="file"><i class="uil uil-camera-plus"></i></label>
                                </form>
                            </div>
                            <h4><?= $user['name'] ?></h4>
                            <p><?= $user['phone'] ?></p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>