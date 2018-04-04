<?php
$user = \array_merge(array('userImg' => 'user.jpg', 'email' => 'Email ID', 'name' => 'Name', 'ph' => 'Contact No.', 'AuthToken' => ''), (\class_exists('AuthComponent') ? AuthComponent::user() : array()));
?>
<ul class="nav navbar-nav">
    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="glyphicon glyphicon-user"></i>
            <span> <i class="caret"></i></span>
        </a>
        <ul class="dropdown-menu">
            <li class="user-header" style="height: auto;">
                <?php
                $email = $user["email"];
                echo $this->Html->image($user["userImg"], array('class' => 'img-circle', 'alt' => "User Image"));
                echo $this->Html->para("", $user["name"] . ' (' . $user["ph"] . ')' . $this->Html->tag('small', empty($user["email"]) ? 'Email ID Not Registered.' : $user["email"]));
                ?>
            </li>
            <li class="user-header" style ="height: 39px;" >
                <?php
                if (AuthComponent::user("logintype") != "HO") {
                    echo "<div class = 'row'>";
                    if (count(AuthComponent::user("db_access")) > 1) {
                        ?>

                        <div class="pull-left col-md-6">
                            <?php
//                            $datArray = array("AuthVar" => AuthComponent::user("AuthToken"), "flag" => "State");
//                            echo $this->Form->postLink(('Change State'), "/PwBoUser/changeStateBranch", array("method" => "POST", "target" => "_self", "data" => $datArray));
                            echo $this->Form->create('changestate', array('method' => 'post', 'target' => '_self', 'url' => array('controller' => 'PwBoUser', 'action' => 'changeStateBranch')));
                            echo $this->Form->hidden('AuthVar', array('value' => $user["AuthToken"]));
                            echo $this->Form->hidden('flag', array('value' => 'State'));
                            echo $this->Form->end(array('label' => 'Change State', 'class' => 'btn-link', 'div' => FALSE));
                            ?>
                        </div>
                        <?php
                    } $temp = AuthComponent::user("branch_access");
                    if (count($temp[AuthComponent::user("db_serno")]) > 1) {
                        ?>
                        <div class="pull-right col-md-6">
                            <?php
//                            $datArray = array("AuthVar" => AuthComponent::user("AuthToken"), "flag" => "Branch");
//                            echo $this->Form->postLink(('Change Branch'), "/PwBoUser/changeStateBranch", array("method" => "POST", "target" => "_self", "data" => $datArray));
                            echo $this->Form->create('changebranch', array('method' => 'post', 'target' => '_self', 'url' => array('controller' => 'PwBoUser', 'action' => 'changeStateBranch')));
                            echo $this->Form->hidden('AuthVar', array('value' => $user["AuthToken"]));
                            echo $this->Form->hidden('flag', array('value' => 'Branch'));
                            echo $this->Form->end(array('label' => 'Change Branch', 'class' => 'btn-link', 'div' => FALSE));
                            ?>
                        </div>

                        <?php
                    }
                    echo "</div>";
                }
                ?>
            </li>
            <li class="user-footer" style=" border-top: 1px solid #ccc;">
                <div class="pull-left">
                    <?php
                    echo $this->Form->create('changepass', array('method' => 'post', 'target' => '_self', 'url' => array('controller' => 'PwBoUser', 'action' => 'ChangePasswd')));
                    echo $this->Form->hidden('AuthVar', array('value' => $user["AuthToken"]));
                    echo $this->Form->end(array('label' => 'Change Password', 'class' => 'btn btn-block btn green', 'div' => FALSE));
                    ?>
                </div>
                <div class="pull-right ">
                    <?php
                    echo $this->Form->create('logout', array('method' => 'post', 'target' => '_self', 'url' => array('controller' => \Configure::read('masterController'), 'action' => 'logout')));
                    echo $this->Form->hidden('AuthVar', array('value' => $user["AuthToken"]));
                    echo $this->Form->end(array('label' => 'Logout', 'class' => 'btn btn-block btn-danger', 'div' => FALSE));
                    ?>
                </div>
            </li>
        </ul>
    </li>
</ul>
<style>
    /*.btn-xs{width: 129px;}*/
</style>