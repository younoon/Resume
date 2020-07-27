package nhs75007.nagoya.ac.mykotlinview

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.text.TextUtils
import android.util.Log
import android.widget.Toast
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.auth.FirebaseUser
import com.google.firebase.database.*
import kotlinx.android.synthetic.main.activity_message.*
import nhs75007.nagoya.ac.mykotlinview.models.Message
import nhs75007.nagoya.ac.mykotlinview.models.User
import java.text.SimpleDateFormat
import java.util.*

class MessageActivity : AppCompatActivity() {

    private val TAG = "MessageActivity"
    private val REQUIRED = "Required"

    private var user: FirebaseUser? = null

    private var mDatabase: DatabaseReference? = null
    private var mMessageReference: DatabaseReference? = null
    private var mMessageListener: ValueEventListener? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_message)

        mDatabase = FirebaseDatabase.getInstance().reference
        mMessageReference = FirebaseDatabase.getInstance().getReference("message")
        user = FirebaseAuth.getInstance().currentUser

        btnSend.setOnClickListener {
            submitMessage()
            edtSentText.setText("")
        }

        btnBack.setOnClickListener {
            finish()
        }
    }

    override fun onStart() {
        super.onStart()

        val messageListener = object : ValueEventListener{
            override fun onDataChange(dataSnapshot: DataSnapshot) {
                if (dataSnapshot.exists()){
                    val message = dataSnapshot.getValue(Message::class.java)

                    Log.e(TAG,"onDataChange: Message data is updated" + message!!.author+ ", "+message.time+", "+message.body)

                    tvAuthor.text = message.author
                    tvTime.text = message.time
                    tvBody.text = message.body
                }
            }

            override fun onCancelled(databaseError: DatabaseError) {
                Log.e(TAG,"onCancelled: Failed to read message")

                tvAuthor.text = ""
                tvTime.text = ""
                tvBody.text = "onCancelled: Failed to read message!"
            }

        }

        mMessageReference!!.addValueEventListener(messageListener)

        mMessageListener = messageListener
    }

    override fun onStop() {
        super.onStop()

        if (mMessageListener != null){
            mMessageReference!!.removeEventListener(mMessageListener!!)
        }
    }

    private fun submitMessage(){
        val body = edtSentText.text.toString()

        if (TextUtils.isEmpty(body)){
            edtSentText.error = REQUIRED
            return
        }

        mDatabase!!.child("users").child(user!!.uid).addListenerForSingleValueEvent(object : ValueEventListener{
            override fun onDataChange(dataSnapshot: DataSnapshot) {
                val user = dataSnapshot.getValue(User::class.java)

                if (user == null){
                    Log.e(TAG,"onDataChange: User data is null!")
                    Toast.makeText(this@MessageActivity, "onDataChange: User data is null!", Toast.LENGTH_SHORT).show()
                    return
                }

                writeNewMessage(body)
            }

            override fun onCancelled(error: DatabaseError) {
                Log.e(TAG, "onCancelled: Failed to read user!")
            }
        })
    }

    private fun writeNewMessage(body:String){
        val time = SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(Calendar.getInstance().time)
        val message = Message(getUsernameFromEmail(user!!.email),body,time)

        mMessageReference!!.setValue(message)
    }

    private fun getUsernameFromEmail(email: String?):String{
        return if (email!!.contains("@")){
            email.split("@".toRegex()).dropLastWhile { it.isEmpty() }.toTypedArray()[0]
        } else {
            email
        }
    }

}
