#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <shadow.h>
#include <unistd.h>
int main(){
	char *user = getenv("USER");
	printf("Doi mat khau cho User: %s\n", user);
	
	struct spwd *spwd = getspnam(user);
	char *pass = getpass("Nhap mat khau cu: ");
	
  	char *encryptpass=crypt(pass,spwd->sp_pwdp);
	// printf("%s\n", *(&encryptpass));
	if(strcmp(encryptpass,spwd->sp_pwdp)!=0){
	    printf("Sai mat khau\n");
	    return -1;
	}
	char *newpass = getpass("Nhap mat khau moi: ");
	encryptpass = crypt(newpass, spwd->sp_pwdp);
	spwd->sp_pwdp=encryptpass;

	FILE *f=fopen("/etc/shadow","r");
  	FILE *ftmp=fopen("/tmp/change.tmp","w");
  	if(f==NULL){
		printf("Khong Mo Duoc File f\n");
		return -1;
	}
	if(ftmp==NULL){
		printf("Khong Mo Duoc File ftmp\n");
		return -1;
	}
	char *read;
	size_t len=0;
	while(getline(&read,&len,f)!=-1){
		if(strstr(read,user)){
			putspent(spwd,ftmp);
	}
		else{
			fputs(read,ftmp);
		}
	}
	remove("/etc/shadow");
	if(!rename("/tmp/change.tmp","/etc/shadow")){
		printf("====Doi mat khau thanh cong====\n");
	}
	fclose(ftmp);
	fclose(f);
} 
