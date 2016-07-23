<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

        <div class="section-modal modal fade" id="services-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="container">              
                    <?php
                     echo get_info('SERVICES');
                    ?>
                </div>
                
            </div>
        </div>