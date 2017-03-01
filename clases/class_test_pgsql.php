/* Execute database query. */
function query($query){
	try{
		$this->result = @pg_query($this->linkid,$query);
		if(! $this->result)
			throw new Exception("The database Wuery failed." + pg_last_error($this->result));
	}
	catch (Exception $e){
		echo $e->getMessage();
	}
	$this->querycount++;
	return $this->result;
}

/* Determine total rows affected by query. */
function affectedRows(){
$count = @pg_affected_rows($this->linkid);
return $count;
}

/* Determine total rows returned by query */
function numRows(){
$count = @pg_num_rows($this->result);
return $count;
}

/* Return query result row as an object. */
function fetchObject(){
$row = @pg_fetch_object($this->result);
return $row;
}
/* Return query result row as an indexed array. */
function fetchRow(){
$row = @pg_fetch_row($this->result);
return $row;
}

/* Return query result row as an associated array. */
function fetchArray(){
$row = @pg_fetch_array($this->result,null,PGSQL_ASSOC);
return $row;
}

/* Return total number of queries executed during
lifetime of this object. Not required, but
interesting nonetheless. */
function numQueries(){
return $this->querycount;
}

/* Return the number of fields in a result set */
function numberFields() {
$count = @pg_num_fields($this->result);
return $count;
}

/* Return a field name given an integer offset. */
function fieldName($offset){
$field = @pg_field_name($this->result, $offset);
return $field;
}
function getResultAsTable() {
if ($this->numrows() > 0) {

// Start the table
$resultHTML = "<table border='0' bgcolor='#FFFFCC' cellspacing='10' cellpadding='2' align='left'><tr>";

// Output the table headers
$fieldCount = $this->numberFields();
for ($i=0; $i < $fieldCount; $i++){
$rowName = $this->fieldName($i);
$sqlPosition = $i+1;
$resultHTML .= "<th><a href=".$_SERVER['PHP_SELF']."?sort=$rowName>$rowName</a></th>";
#$resultHTML .= “<th>$rowName</th>”;
} // end for

// Close the row
$resultHTML .= "</tr>";

// Output the table data
while ($row = $this->fetchRow()){
$resultHTML .= "<tr>";
for ($i = 0; $i < $fieldCount; $i++)
$resultHTML .= "<td>".htmlentities($row[$i])."</td>";
$resultHTML .= "</tr>";
}
// Close the table
$resultHTML .= "</table>";
}
else {
$resultHTML = "<p>No Results Found</p>";
}
return $resultHTML;
}

function pageLinks($totalpages, $currentpage, $pagesize, $parameter) {
// Start at page one
$page = 1;
// Start at record 0
$recordstart = 0;
// Initialize page links
$pageLinks = ”;
while ($page <= $totalpages) {
// Link the page if it isn’t the current one
if ($page != $currentpage) {
$pageLinks .= "<a href=".$_SERVER['PHP_SELF'].
"?$parameter=$recordstart>$page</a>";
// If the current page, just list the number
}
else {
$pageLinks .= "$page";
}
// Move to the next record delimiter
$recordstart += $pagesize;
$page++;
}
return $pageLinks;
}

#Handling Transaction Processing
function begintransaction() {
$this->query('START TRANSACTION');
}

function commit() {
$this->query('COMMIT');
}

function rollback() {
$this->query('ROLLBACK');
}

function setsavepoint($savepointname){
$this->query("SAVEPOINT $savepointname");
}

function rollbacktosavepoint($savepointname){
$this->query("ROLLBACK TO SAVEPOINT $savepointname");
}

function setTransactionParamsSerialisable(){
$this->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");

}

function setTransactionParamsReadCommited(){
$this->query("SET TRANSACTION ISOLATION LEVEL READ COMMITTED");

}