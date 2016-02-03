--
-- Table structure for table `user_more_info`
--

CREATE TABLE IF NOT EXISTS `user_more_info` (
`umf_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `website` varchar(255) NOT NULL,
  `how_you_find` text NOT NULL,
  `important` text NOT NULL,
  `avg_sales` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Indexes for table `user_more_info`
--
ALTER TABLE `user_more_info`
 ADD PRIMARY KEY (`umf_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_more_info`
--
ALTER TABLE `user_more_info`
MODIFY `umf_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;