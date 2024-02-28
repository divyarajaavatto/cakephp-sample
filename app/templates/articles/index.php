
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light text-right">
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
      <?= $this->Html->link(__('New Article'), ['action' => 'add'], [ 'class' => 'nav-link']) ?>
      </li>
      <li class="nav-item">
      <?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index'], [ 'class' => 'nav-link']) ?>
      </li>
    </ul>
  </div>
</nav> -->
<div class="row ssm-main-page">
    <div class="col-sm-12 float-right">
        <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn btn-danger float-right']) ?>
    </div>
</div>
<div class="row ssm-main-page mr-0 ml-0">
    <div class="col-sm pl-0 pr-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th><?= 'Sr No.' ?></th>
                        <th><?= $this->Paginator->sort('title') ?></th>
                        <th><?= $this->Paginator->sort('body') ?></th>
                        <th><?= $this->Paginator->sort('No. of Likes') ?></th>
                        <th><?= 'Actions' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i= 0;
                    foreach ($articles as $article): 
                    $i++;
                    ?>
                        <tr>
                            <td><?= h($i) ?></td>
                            <td><?= h($article->title) ?></td>
                            <td><?= h($article->body) ?></td>
                            <td><?= count($article->likes) ?></td>
                            <td class="actions">
                                <?php if(!$article->isLikeByUser($article->id, $this->request->getAttribute('identity')->getIdentifier())){ ?>
                                <?= $this->Html->link(__('Like Article'), ['action' => 'like', $article->id]) ?>
                                <?php } ?>
                                <!-- <?= $this->Html->link(__('Edit'), ['action' => 'edit', $article->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $article->id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->id)]) ?> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>