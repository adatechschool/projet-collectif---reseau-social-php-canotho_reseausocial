<?php while ($post = $lesInformations->fetch_assoc())
                {
                
                ?>
                <article>
                    <img src="user.jpg" alt="blason"/>
                    <!-- <h3><?php echo $post['alias'] ?></h3> -->
                    <a href="wall.php?user_id=<?php echo $post['id'] ?>"><?php echo $post['alias'] ?></a>
                    <p>id:<?php echo $post['id'] ?></p>                    
                </article> 
                <?php }; ?>