<article>
                        <h3>
                            <time><?php echo $post['created'] ?></time>
                        </h3>
                        <address><?php echo $post['author_name'] ?></address>
                        <div>
                            <p><?php echo $post['content'] ?></p>
                        </div>
                        <footer>
                            <small> <?php echo '♥'.$post['like_number'] ?></small>
                            <?php
                                $tagArray=array();
                                $stringToBreak=$post['taglist'];
                                $tagArray=explode("," , $stringToBreak);
                                foreach( $tagArray as $element){
                            ?>    
                                 <a href=""> <?php echo '#'.$element ?></a>
                                <?php
                                }?>
                        </footer>
                    </article>